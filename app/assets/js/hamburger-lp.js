const menuToggle = document.getElementById("menuToggle");
const navbar = document.getElementById("navbar");

// Toggle menu saat ikon diklik
menuToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  navbar.classList.toggle("show");
});

document.addEventListener("click", (e) => {
  if (!navbar.contains(e.target) && !menuToggle.contains(e.target)) {
    navbar.classList.remove("show");
  }
});

window.addEventListener("scroll", () => {
  navbar.classList.remove("show");
});
