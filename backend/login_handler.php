<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// update with the hash passwords.
if ($email == $_SESSION['registered_email'] && password_verify($password, $_SESSION['registered_password'])) {
    $_SESSION['login'] = 1;

    setcookie("user_email", $email, time() + 3600, "/");

    header("Location: ../templates/dashboard.php");
    exit();
} else {
    header("Location: ../templates/landing_page.php");
    exit();
}
?>