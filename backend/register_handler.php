<?php
session_start();

function checkUserData($inputData)
{
    $inputData = htmlspecialchars($inputData);
    $inputData = trim($inputData);
    $inputData = stripslashes($inputData);
    return $inputData;
}

function sanityCheck($data, $type, $length)
{
    $type = "is_" . $type;

    if (!$type($data)) {
        return false;
    } elseif (empty($data)) {
        return false;
    } elseif (strlen($data) > $length) {
        return false;
    } else {
        return true;
    }
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../templates/register.php");
    exit();
}

$usernameErr = "";
$emailErr = "";
$passwordErr = "";
$confirmPasswordErr = "";

$username = "";
$email = "";
$password = "";
$confirmPassword = "";

if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
} else {
    $username = checkUserData($_POST["username"]);

    if (!sanityCheck($username, "string", 20)) {
        $usernameErr = "Username must be text and 20 characters or less";
    }
}

if (empty($_POST["email"])) {
    $emailErr = "Email is required";
} else {
    $email = checkUserData($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Valid email is required";
    } elseif (!sanityCheck($email, "string", 50)) {
        $emailErr = "Email must be 50 characters or less";
    }
}

if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
} else {
    $password = checkUserData($_POST["password"]);

    if (!sanityCheck($password, "string", 20)) {
        $passwordErr = "Password must be 20 characters or less";
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    }
}

if (empty($_POST["confirm_password"])) {
    $confirmPasswordErr = "Please confirm your password";
} else {
    $confirmPassword = checkUserData($_POST["confirm_password"]);

    if ($password !== "" && $confirmPassword !== $password) {
        $confirmPasswordErr = "Passwords do not match";
    }
}

if ($usernameErr != "" || $emailErr != "" || $passwordErr != "" || $confirmPasswordErr != "") {
    $_SESSION["registerUsernameErr"] = $usernameErr;
    $_SESSION["registerEmailErr"] = $emailErr;
    $_SESSION["registerPasswordErr"] = $passwordErr;
    $_SESSION["registerConfirmPasswordErr"] = $confirmPasswordErr;
    $_SESSION["registerUsername"] = $username;
    $_SESSION["registerEmail"] = $email;

    header("Location: ../templates/register.php");
    exit();
}

$_SESSION["registeredUsername"] = $username;
$_SESSION["registeredEmail"] = $email;
$_SESSION["registeredPassword"] = $password;
$_SESSION["loginMessage"] = "Registration complete. You can now sign in.";

header("Location: ../templates/login_page.php");
exit();
?>
