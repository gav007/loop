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

function loopShareListing(title) {
  var url = window.location.href;
  if (navigator.share) {
    navigator.share({ title: title + ' on Loop', url: url }).catch(function() {});
  } else {
    navigator.clipboard.writeText(url).then(function() {
      var toast = document.getElementById('loop-share-toast');
      if (toast) {
        toast.style.display = 'block';
        setTimeout(function() { toast.style.display = 'none'; }, 2000);
      }
    }).catch(function() {});
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
