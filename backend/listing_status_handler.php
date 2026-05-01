<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: ../templates/landing_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/marketplace.php");
    exit();
}

include("db_connect.php");
require_once("recommendations.php");

$user_id = loop_user_id();
$listing_id = isset($_POST['listing_id']) ? (int) $_POST['listing_id'] : 0;
$status = trim($_POST['status'] ?? "");
$allowed_statuses = ["active", "unavailable", "archived"];

if ($listing_id <= 0 || !in_array($status, $allowed_statuses, true)) {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
    header("Location: ../templates/marketplace.php");
    exit();
}

$stmt = $conn->prepare("UPDATE listings SET status = ? WHERE id = ? AND user_id = ?");

if (!$stmt) {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
    $conn->close();
    header("Location: ../templates/listing_detail.php?id=" . $listing_id);
    exit();
}

$stmt->bind_param("sii", $status, $listing_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Listing status updated.";
} else {
    $_SESSION['listing_error'] = "Only the listing owner can change this status.";
}

$stmt->close();
$conn->close();
header("Location: ../templates/listing_detail.php?id=" . $listing_id);
exit();
?>
