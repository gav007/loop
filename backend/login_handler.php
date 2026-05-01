<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/landing_page.php");
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

include("db_connect.php");

$safe_email = $conn->real_escape_string($email);

$sql = "SELECT * FROM users WHERE email = '$safe_email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['login'] = 1;
        $_SESSION['user_id'] = isset($user['id']) ? (int) $user['id'] : 0;
        $_SESSION['registered_username'] = $user['username'];
        $_SESSION['registered_email'] = $user['email'];

        setcookie("user_email", $email, time() + 3600, "/");

        $conn->close();
        header("Location: ../templates/dashboard.php");
        exit();
    }
}

$_SESSION["error"] = "Email or password is incorrect.";
$conn->close();
header("Location: ../templates/landing_page.php");
exit();
?>
