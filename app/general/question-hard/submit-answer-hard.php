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

// SweetAlert popup helper
function showAlert($title, $message, $icon = 'error') {
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
        1 => ['Waste Land','Starry Night'],
        2 => ['Breaks', 'Break', 'Relax'],
        3 => ['White', 'pink','yellow','Blue','Green','happiness','nature'],
        4 => ['Flying','sky','nature','vibrant','colour','pollinating plants','dispersing seeds','insect populations'],
        5 => ['knowledge','improve','vocabulary','critical thinking','reading books','cultures','perspectives','relax','escape','reality'],
        6 => ['riding','mountain','road','immerse','natural','breathtaking','fresh','adventure','motorcycling','exhilarating','discovery']
    ];

    if ($question_id < 1 || $question_id > 6 || empty($answer)) {
        showAlert("Invalid Input", "Question or answer is missing or invalid.");
    }

    $user_answer = strtolower(trim($answer));

    if (!preg_match('/^[a-zA-Z\s,\.\'"]+$/', $user_answer)) {
        showAlert("Invalid Characters", "Answer must only contain English letters, spaces, commas, periods, and quotes.");
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
    'membaca', 'menulis', 'menggambar', 'mewarnai', 'bermain', 'berlari', 'melompat', 'menari', 'menyanyi', 'berbicara',];
    foreach ($indonesian_keywords as $indo_word) {
        if (preg_match('/\b' . preg_quote($indo_word, '/') . '\b/i', $user_answer)) {
            showAlert("Language Warning", "Please answer only in English.");
        }
    }

    $bad_words = [$bad_words = 
        'fuck', 'shit', 'bitch', 'asshole', 'damn', 'bastard', 'idiot', 'stupid', 'fucking', 'jerk',
        'dick', 'pussy', 'slut', 'moron', 'retard', 'crap', 'suck', 'whore', 'cock', 'motherfucker',
        'cunt', 'bullshit', 'dumbass', 'son of a bitch', 'twat', 'wanker', 'prick', 'scumbag', 'hoe', 'loser',
        'jackass', 'dipshit', 'freak', 'shithead', 'fuckface', 'screw you', 'bastards', 'piss off', 'bitchy', 'arsehole',
        'sialan', 'bajingan', 'anjing', 'bangsat', 'kampret', 'tai', 'brengsek', 'goblok', 'tolol', 'keparat',
        'setan', 'iblis', 'kontol', 'memek', 'perek', 'pelacur', 'bodoh', 'kamvret', 'sinting', 'edun',
        'laknat', 'bencong', 'banci', 'pecundang', 'jancuk', 'ngentot', 'sundal', 'titit', 'pantek', 'bego',
        'nggak guna', 'ngeselin', 'dablek', 'bangke', 'anjir', 'kacrut', 'mati aja', 'kambing lo', 'kapok', 'mampus',
        'dihina', 'pengkhianat', 'muka dua', 'rakus', 'serakah', 'brengsek lu', 'cacat', 'pengemis', 'nyebelin', 'nyusahin',
        'bacot', 'mulut besar', 'ngehe', 'jijik', 'busuk', 'bau badan', 'lo ngapain', 'apa lo', 'mukalu jelek', 'alay'
    ];
   
    foreach ($bad_words as $bad_word) {
        if (preg_match('/\b' . preg_quote($bad_word, '/') . '\b/i', $user_answer)) {
            showAlert("Inappropriate Language", "Please remove inappropriate or offensive words from your answer.");
        }
    }

    if (str_word_count($user_answer) < 5) {
        showAlert("Answer Too Short", "Please provide a more complete answer with at least 5 words.", "warning");
    }

    // Check if the answer contains any expected keywords
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

    $stmt = $conn->prepare("REPLACE INTO user_answers_hard (fullname, question_id, answer, is_correct) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sisi", $fullname, $question_id, $answer, $is_correct);
    $stmt->execute();
    $stmt->close();

    if ($question_id >= 1 && $question_id < 6) {
        header("Location: " . $base_url . "app/general/pict-general-hard.php");
    } elseif ($question_id == 6) {
        header("Location: " . $base_url . "app/general/question-hard/result-hard.php");
    }
    exit();
} else {
    showAlert("Invalid Request", "Only POST method is allowed.");
}
?>
