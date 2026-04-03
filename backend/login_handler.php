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
    header("Location: ../templates/login_page.php");
    exit();
}

$emailErr = "";
$passwordErr = "";
$email = "";
$password = "";

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
    }
}

if ($emailErr != "" || $passwordErr != "") {
    $_SESSION["loginEmailErr"] = $emailErr;
    $_SESSION["loginPasswordErr"] = $passwordErr;
    $_SESSION["loginEmail"] = $email;

    header("Location: ../templates/login_page.php");
    exit();
}

if (!isset($_SESSION["registeredEmail"]) || !isset($_SESSION["registeredPassword"])) {
    $_SESSION["loginError"] = "Create an account first before trying to sign in.";
    $_SESSION["loginEmail"] = $email;

    header("Location: ../templates/login_page.php");
    exit();
}

if ($email == $_SESSION["registeredEmail"] && $password == $_SESSION["registeredPassword"]) {
    $_SESSION["login"] = 1;
    $_SESSION["username"] = $_SESSION["registeredUsername"];
    $_SESSION["userEmail"] = $_SESSION["registeredEmail"];

    header("Location: ../templates/dashboard.php");
    exit();
}

$_SESSION["loginError"] = "Login unsuccessful. Check your email and password.";
$_SESSION["loginEmail"] = $email;

header("Location: ../templates/login_page.php");
exit();
?>
