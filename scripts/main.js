function myFunction() {
  let element = document.body;
  element.classList.toggle("dark-theme");
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
