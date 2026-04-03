function myFunction() {
  let element = document.body;
  element.classList.toggle("dark-theme");
}

function validatePassword() {
  //grabs password value
  let password = document.getElementById("password").value;
  // grabs confirm value
  let confirmPassword = document.getElementById("confirm_password").value;
  // notice message in p tag
  let notice = document.getElementById("notice");

  if (password != confirmPassword) {
    if (notice != null) {
      notice.textContent = "Passwords do not match";
    }
    alert("Passwords do not match");
    return false;
  } else {
    if (notice != null) {
      notice.textContent = null;
    }
    return true;
  }
}

// 1. Find the logo text box
const logoText = document.querySelector(".brand-name");
