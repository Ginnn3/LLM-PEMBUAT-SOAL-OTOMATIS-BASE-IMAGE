document.getElementById("upload-form").addEventListener("submit", function (e) {
  e.preventDefault(); // Menghindari form submit otomatis

  const formData = new FormData();
  const fileInput = document.getElementById("file-upload");

  if (fileInput.files.length > 0) {
    formData.append("image", fileInput.files[0]);

    // Mengirim file gambar ke server PHP (URL diperbarui dengan path yang benar)
    fetch("http://localhost/APLIKASI-TA/app/teacher/upload/upload-tc.php", {
      // Sesuaikan dengan URL yang benar
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        // Menampilkan hasil pertanyaan setelah mendapatkan response dari PHP
        document.getElementById("result").innerHTML = data;
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("There was an error uploading the image.");
      });
  } else {
    alert("Please upload an image!");
  }
});
