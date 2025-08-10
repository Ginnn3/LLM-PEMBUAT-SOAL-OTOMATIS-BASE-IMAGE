document.getElementById("subscribeBtn").addEventListener("click", function () {
  const email = document.getElementById("userEmail").value.trim();
  if (email) {
    const subject = encodeURIComponent("Newsletter Subscription Request");
    const body = encodeURIComponent(
      `Hi, please subscribe me with this email:\n\n${email}`
    );
  } else {
    alert("Tolong masukan email anda dengan benar.");
  }
});
