<?php
session_start();



// adapted from lab 5
// defines the variables

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
        $_SESSION["error"] = $usernameErr . " " . $emailErr . " " . $passwordErr . " " . $confirm_passwordErr;
        header("Location: ../templates/register.php");
        exit();
    }

    include("db_connect.php");
    // hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password)
    VALUES ('$username', '$email', '$hashed_password')";

    
    if ($conn->query($sql) === TRUE) {
        $_SESSION["registered_username"] = $username;
        $_SESSION["registered_email"] = $email;
        $_SESSION["registered_password"] = $password;
        $_SESSION["success"] = "Registration successful. Please log in.";
        $conn ->close();
        header("Location: ../templates/landing_page.php");
        exit();
    } else {
    echo "Error: " . $conn->error;
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
