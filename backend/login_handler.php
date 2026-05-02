<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/landing_page.php");
    exit();
}

$email = trim($_POST['email'] ?? "");
$password = $_POST['password'] ?? "";

include("db_connect.php");

$stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ? LIMIT 1");

if (!$stmt) {
    $_SESSION["error"] = "Email or password is incorrect.";
    $conn->close();
    header("Location: ../templates/landing_page.php");
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['login'] = 1;
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['registered_username'] = $user['username'];
        $_SESSION['registered_email'] = $user['email'];

        setcookie("user_email", $email, [
            'expires'  => time() + 3600,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        $stmt->close();
        $conn->close();
        header("Location: ../templates/dashboard.php");
        exit();
    }
}

$stmt->close();
$_SESSION["error"] = "Email or password is incorrect.";
$conn->close();
header("Location: ../templates/landing_page.php");
exit();
?>
