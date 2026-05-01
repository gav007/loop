<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: ../templates/landing_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/profile.php");
    exit();
}

include("db_connect.php");
require_once("recommendations.php");

$user_id = loop_user_id();
$allowed_interests = loop_interests();
$selected_interests = $_POST['interests'] ?? [];

if (!is_array($selected_interests)) {
    $selected_interests = [];
}

$clean_interests = [];
foreach ($selected_interests as $interest) {
    if (in_array($interest, $allowed_interests, true)) {
        $clean_interests[] = $interest;
    }
}

$clean_interests = array_values(array_unique($clean_interests));

$delete_stmt = $conn->prepare("DELETE FROM user_interests WHERE user_id = ?");
if (!$delete_stmt) {
    $_SESSION['profile_error'] = "Interests could not be saved right now.";
    $conn->close();
    header("Location: ../templates/profile.php");
    exit();
}

$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();
$delete_stmt->close();

if (!empty($clean_interests)) {
    $insert_stmt = $conn->prepare(
        "INSERT INTO user_interests (user_id, interest, weight) VALUES (?, ?, 50)"
    );

    if (!$insert_stmt) {
        $_SESSION['profile_error'] = "Interests could not be saved right now.";
        $conn->close();
        header("Location: ../templates/profile.php");
        exit();
    }

    foreach ($clean_interests as $interest) {
        $insert_stmt->bind_param("is", $user_id, $interest);
        $insert_stmt->execute();
    }

    $insert_stmt->close();
}

$_SESSION['success'] = "Interests saved.";
$conn->close();
header("Location: ../templates/profile.php");
exit();
?>
