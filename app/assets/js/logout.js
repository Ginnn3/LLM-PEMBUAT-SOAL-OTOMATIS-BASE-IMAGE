document.addEventListener("DOMContentLoaded", function () {
  const logoutBtn = document.getElementById("logoutBtn");
  if (!logoutBtn) return;

  logoutBtn.addEventListener("click", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Apakah Anda yakin ingin keluar?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, keluar",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = BASE_URL + "app/auth/logout.php";
      }
    });
  });
});
