function myFunction() {
  let element = document.body;
  element.classList.toggle("dark-theme");

  let logo = document.getElementById("hero-logo");

  if (logo != null) {
    if (element.classList.contains("dark-theme")) {
      logo.src = "../assets/inverted_new2.pgn.png";
    } else {
      logo.src = "../assets/loop.png";
    }
  }
}

function validatePassword() {
  let password = document.getElementById("password").value;
  let confirmPassword = document.getElementById("confirm_password").value;

  if (password != confirmPassword) {
    alert("Passwords do not match");
    return false;
  }

  return true;
}
