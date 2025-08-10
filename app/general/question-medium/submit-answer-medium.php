<?php
include_once(__DIR__ . '/../../../config.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$conn = new mysqli("localhost", "root", "", "db_ta");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function showSweetAlertAndExit($title, $message, $icon = 'error') {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Alert</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$message',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = isset($_POST['question_id']) ? (int)$_POST['question_id'] : 0;
    $answer = trim($_POST['answer'] ?? '');

    $correct_answers = [
        1 => ['yellow'],
        2 => ['blue'],
        3 => ['12.00','12:00', 'twelve'],
        4 => ['laptop'],
        5 => ['pink'],
        6 => ['paintbrush']
    ];

    if ($question_id < 1 || $question_id > 6 || empty($answer)) {
        showSweetAlertAndExit('Invalid Input', 'Invalid question or empty answer.');
    }
    $user_answer = strtolower($answer);

    if (!preg_match('/^[a-z0-9\s\.,\'"-?!()]+$/i', $user_answer)) {
        showSweetAlertAndExit('Invalid Characters', 'Answer must only contain English characters and punctuation.');
    }
    $indonesian_keywords = ['saya', 'adalah', 'dan', 'itu', 'di', 'ke', 'dari', 'pelajaran', 'murid', 'kelas', 'buku', 'guru', 'belajar', 
        'saya', 'adalah', 'dan', 'itu', 'di', 'ke', 'dari', 'pelajaran', 'murid', 'kelas',
        'buku', 'guru', 'belajar', 'merah', 'biru', 'kuning', 'hijau', 'putih', 'hitam', 'ungu',
        'coklat', 'jingga', 'abu-abu', 'meja', 'kursi', 'lemari', 'papan', 'penghapus', 'pensil', 'pulpen',
        'penggaris', 'tas', 'sepatu', 'lingkaran', 'persegi', 'segitiga', 'persegi panjang', 'oval', 'bintang', 'trapesium',
        'jajar genjang', 'kubus', 'bola', 'komputer', 'kipas', 'lampu', 'jendela', 'pintu', 'televisi', 'printer',
        'rak', 'jam', 'kamera', 'kucing', 'anjing', 'burung', 'ikan', 'kuda', 'gajah', 'sapi',
        'kambing', 'kelinci', 'ayam', 'pohon', 'bunga', 'rumput', 'daun', 'batang', 'akar', 'buah',
        'biji', 'kelapa', 'mangga', 'spidol', 'pena', 'buku tulis', 'stapler', 'kertas', 'pengait', 'klip',
        'lem', 'sekolah', 'rumah', 'kantor', 'pasar', 'taman', 'jalan', 'perpustakaan', 'lab', 'kantin',
        'membaca', 'menulis', 'menggambar', 'mewarnai', 'bermain', 'berlari', 'melompat', 'menari', 'menyanyi', 'berbicara',
    ];

    foreach ($indonesian_keywords as $indo_word) {
        if (preg_match('/\b' . preg_quote($indo_word, '/') . '\b/i', $user_answer)) {
            showSweetAlertAndExit('Invalid Input', 'Please answer only in English.');
        }
    }
    $bad_words = [ 'fuck', 'shit', 'bitch', 'asshole', 'damn', 'bastard', 'idiot', 'stupid', 'fucking', 'jerk',
    'dick', 'pussy', 'slut', 'moron', 'retard', 'crap', 'suck', 'whore', 'cock', 'motherfucker',
    'cunt', 'bullshit', 'dumbass', 'son of a bitch', 'twat', 'wanker', 'prick', 'scumbag', 'hoe', 'loser',
    'jackass', 'dipshit', 'freak', 'shithead', 'fuckface', 'screw you', 'bastards', 'piss off', 'bitchy', 'arsehole',
    'sialan', 'bajingan', 'anjing', 'bangsat', 'kampret', 'tai', 'brengsek', 'goblok', 'tolol', 'keparat',
    'setan', 'iblis', 'kontol', 'memek', 'perek', 'pelacur', 'bodoh', 'kamvret', 'sinting', 'edun',
    'laknat', 'bencong', 'banci', 'pecundang', 'jancuk', 'ngentot', 'sundal', 'titit', 'pantek', 'bego',
    'nggak guna', 'ngeselin', 'dablek', 'bangke', 'anjir', 'kacrut', 'mati aja', 'kambing lo', 'kapok', 'mampus',
    'dihina', 'pengkhianat', 'muka dua', 'rakus', 'serakah', 'brengsek lu', 'cacat', 'pengemis', 'nyebelin', 'nyusahin',
    'bacot', 'mulut besar', 'ngehe', 'jijik', 'busuk', 'bau badan', 'lo ngapain', 'apa lo', 'mukalu jelek', 'alay'];
    foreach ($bad_words as $bad_word) {
        if (preg_match('/\b' . preg_quote($bad_word, '/') . '\b/i', $user_answer)) {
            showSweetAlertAndExit('Inappropriate Language', 'Please remove bad words from your answer.');
        }
    }

    if (str_word_count($user_answer) < 1) {
        showSweetAlertAndExit('Too Short!', 'Please provide a more complete answer (at least 2 words).', 'warning');
    }

    // Check correctness
    $is_correct = 0;
    if (isset($correct_answers[$question_id])) {
        foreach ($correct_answers[$question_id] as $correct) {
            $keywords = preg_split('/\s+/', strtolower($correct));
            foreach ($keywords as $keyword) {
                if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $user_answer)) {
                    $is_correct = 1;
                    break 2;
                }
            }
        }
    }

    $stmt = $conn->prepare("REPLACE INTO user_answers_medium (fullname, question_id, answer, is_correct) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sisi", $fullname, $question_id, $answer, $is_correct);
    $stmt->execute();
    $stmt->close();

    // Redirect next question or result
    if ($question_id >= 1 && $question_id < 6) {
        header("Location: " . $base_url . "app/general/pict-general-medium.php");
    } elseif ($question_id == 6) {
        header("Location: " . $base_url . "app/general/question-medium/result-medium.php");
    }
    exit();
} else {
    showSweetAlertAndExit('Invalid Request', 'Request method not allowed.');
}
?>
