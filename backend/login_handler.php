<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../templates/landing_page.php");
    exit();
}

$email = trim($_POST["email"]);
$password = $_POST["password"];

if (empty($email) || empty($password)) {
    $_SESSION["error"] = "Please enter your email and password.";
    header("Location: ../templates/landing_page.php");
    exit();
}

$sql = "SELECT username, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION["error"] = "Something went wrong. Please try again.";
    $conn->close();
    header("Location: ../templates/landing_page.php");
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        $_SESSION["login"] = 1;
        $_SESSION["registered_username"] = $user["username"];
        $_SESSION["registered_email"] = $user["email"];
        $_SESSION["success"] = "Login successful.";

        setcookie("user_email", $user["email"], time() + 3600, "/");

        $stmt->close();
        $conn->close();

        header("Location: ../templates/dashboard.php");
        exit();
    }
}

$_SESSION["error"] = "Invalid email or password.";
$stmt->close();
$conn->close();

header("Location: ../templates/landing_page.php");
exit();
?>
