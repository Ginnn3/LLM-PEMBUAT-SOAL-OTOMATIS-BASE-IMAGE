function animateTextById(id, sentence, delay = 300, callback = null) {
  const element = document.getElementById(id);
  const words = sentence.split(" ");
  let index = 0;
  function next() {
    if (index < words.length) {
      element.innerHTML += words[index] + " ";
      index++;
      setTimeout(next, delay);
    } else if (callback) {
      callback();
    }
  }
  next();
}

// Jalankan animasi berurutan
animateTextById(
  "animatedText",
  "Please select the difficulty level you wish to choose for the Challenge",
  50,
  () => {
    animateTextById(
      "p1",
      "Easy level for Multiple Choice type questions",
      50,
      () => {
        animateTextById(
          "p2",
          "Medium level for Short Answer type questions",
          50,
          () => {
            animateTextById("p3", "Hard level for Essay type questions", 50);
          }
        );
      }
    );
  }
);
