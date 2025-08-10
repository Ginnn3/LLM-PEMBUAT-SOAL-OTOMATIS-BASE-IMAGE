function animateTextById(id, sentence, delay = 300, callback = null) {
  const element = document.getElementById(id);
  const words = sentence.split(" ");
  let index = 0;
  element.innerHTML = "";

  function next() {
    if (index < words.length) {
      element.innerHTML += words[index] + " ";
      index++;
      setTimeout(next, delay);
    } else if (callback) {
      setTimeout(callback, 100);
    }
  }

  next();
}

function startAnimationLoop() {
  const p1 = document.getElementById("p1");
  p1.innerHTML = ""; // Kosongkan p1 sebelum animasi utama dimulai ulang

  animateTextById(
    "animatedText",
    "Improve Your English With Picture-Based Questions",
    200,
    () => {
      animateTextById(
        "p1",
        "Let's create automatic practice question from images with the help of AI, then challenge yourself of answer question of varying difficulty levels.",
        100,
        () => {
          setTimeout(startAnimationLoop, 2000); // Ulangi semua setelah 2 detik
        }
      );
    }
  );
}

// Jalankan pertama kali
startAnimationLoop();
