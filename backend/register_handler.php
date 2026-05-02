<?php
session_start();

$username = "";
$email = "";
$password = "";
$confirm_password = "";

$usernameErr = "";
$emailErr = "";
$passwordErr = "";
$confirm_passwordErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (empty($_POST['username'])) {
        $usernameErr = "Name is required";
    }
    else {
        $username = clean_data($_POST["username"]);
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    }
    else {
        $email = clean_data($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "This is not a valid email";
        } elseif (!preg_match('/@(tudublin\.ie|mytudublin\.ie)$/i', $email)) {
            $emailErr = "Please use your TU Dublin email address (@tudublin.ie or @mytudublin.ie)";
        }
    }

    if (empty($_POST['password'])) {
        $passwordErr = "Must contain a password";
    }
    else {
        $password = clean_data($_POST["password"]);

        if (!sanity_check($password, "string", 8)) {
            $passwordErr = "Password must be at least 8 characters long";
        }
    }

    if (empty($_POST['confirm_password'])) {
        $confirm_passwordErr = "Please confirm your password";
    }
    else {
        $confirm_password = clean_data($_POST["confirm_password"]);

        if ($password != $confirm_password) {
            $confirm_passwordErr = "Passwords do not match";
        }
    }

    if (
        $usernameErr != "" ||
        $emailErr != "" ||
        $passwordErr != "" ||
        $confirm_passwordErr != ""
    ) {
        $_SESSION["error"] = trim($usernameErr . " " . $emailErr . " " . $passwordErr . " " . $confirm_passwordErr);
        header("Location: ../templates/register.php");
        exit();
    }

    include("db_connect.php");

    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");

    if (!$check_stmt) {
        $_SESSION["error"] = "Registration failed. Please try again.";
        $conn->close();
        header("Location: ../templates/register.php");
        exit();
    }

    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        $_SESSION["error"] = "This email is already registered. Please use a different email or log in.";
        $conn->close();
        header("Location: ../templates/register.php");
        exit();
    }

    $check_stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    if (!$insert_stmt) {
        $_SESSION["error"] = "Registration failed. Please try again.";
        $conn->close();
        header("Location: ../templates/register.php");
        exit();
    }

    $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($insert_stmt->execute()) {
        $insert_stmt->close();
        $_SESSION["registered_username"] = $username;
        $_SESSION["registered_email"] = $email;
        $_SESSION["show_onboarding"] = true;
        $_SESSION["success"] = "Registration successful. Please log in.";
        $conn->close();
        header("Location: ../templates/landing_page.php");
        exit();
    } else {
        $insert_stmt->close();
        $_SESSION["error"] = "Registration failed. Please try again.";
        $conn->close();
        header("Location: ../templates/register.php");
        exit();
    }
}

header("Location: ../templates/register.php");
exit();

function clean_data($inputdata) {
    $inputdata = trim($inputdata);
    $inputdata = stripslashes($inputdata);
    $inputdata = htmlspecialchars($inputdata);
    return $inputdata;
}

function sanity_check($data, $type, $minLength) {
    $type = 'is_' . $type;

    if (empty($data)) {
        return false;
    }

    if (!$type($data)) {
        return false;
    }

    if (strlen($data) < $minLength) {
        return false;
    }

    return true;
}
?>
