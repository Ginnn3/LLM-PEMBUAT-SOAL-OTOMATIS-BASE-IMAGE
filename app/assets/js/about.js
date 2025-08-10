const text = `Selamat datang di aplikasi pembelajaran Bahasa Inggris berbasis gambar 
yang dirancang untuk memberikan pengalaman belajar yang interaktif, menyenangkan, dan efisien bagi semua kalangan. 
Dengan menggabungkan teknologi Artificial Intelligence (AI) dan pendekatan visual, kami menciptakan platform inovatif 
yang mampu menghasilkan soal latihan otomatis dari gambar, serta menyediakan soal-soal latihan yang bisa langsung dikerjakan oleh pengguna.<br><br>
Tujuan utama dari aplikasi ini adalah untuk:<br>
• Membantu pengguna umum (pelajar, mahasiswa, masyarakat umum) meningkatkan kemampuan Bahasa Inggris mereka secara bertahap melalui latihan soal berbasis gambar.<br>
• Mempermudah para pengajar atau guru dalam membuat soal latihan tanpa harus menyusunnya secara manual satu per satu.`;

const words = text.split(/(\s+|<br>)/g);

const container = document.getElementById("animated-text");

let index = 0;

function showNextWord() {
  if (index < words.length) {
    container.innerHTML += words[index];
    index++;
    setTimeout(showNextWord, 25);
  }
}

showNextWord();
