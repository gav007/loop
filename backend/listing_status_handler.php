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
$allowed_statuses = loop_listing_statuses();

function loop_status_redirect_path($listing_id) {
    $redirect = $_POST['redirect'] ?? "listing_detail.php?id=" . $listing_id;

    if (preg_match('/\A(?:my_listings\.php|listing_detail\.php\?id=\d+|marketplace\.php(?:\?[A-Za-z0-9%&=+_.~-]*)?)\z/', $redirect)) {
        return "../templates/" . $redirect;
    }

    return "../templates/listing_detail.php?id=" . $listing_id;
}

if ($listing_id <= 0 || !in_array($status, $allowed_statuses, true)) {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
    header("Location: ../templates/marketplace.php");
    exit();
}

$redirect_path = loop_status_redirect_path($listing_id);

$owner_stmt = $conn->prepare("SELECT status, title FROM listings WHERE id = ? AND user_id = ? LIMIT 1");

if (!$owner_stmt) {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
    $conn->close();
    header("Location: " . $redirect_path);
    exit();
}

$owner_stmt->bind_param("ii", $listing_id, $user_id);
$owner_stmt->execute();
$owner_result = $owner_stmt->get_result();
$owned_listing = $owner_result->fetch_assoc();
$owner_stmt->close();

if (!$owned_listing) {
    $_SESSION['listing_error'] = "Only the listing owner can change this status.";
    $conn->close();
    header("Location: " . $redirect_path);
    exit();
}

if ($owned_listing['status'] === $status) {
    $_SESSION['success'] = "Listing is already marked " . strtolower(loop_pretty_status($status)) . ".";
    $conn->close();
    header("Location: " . $redirect_path);
    exit();
}

$stmt = $conn->prepare("UPDATE listings SET status = ? WHERE id = ? AND user_id = ?");

if (!$stmt) {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
    $conn->close();
    header("Location: " . $redirect_path);
    exit();
}

$stmt->bind_param("sii", $status, $listing_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    if ($status === 'reused') {
        $_SESSION['reused_celebration'] = $owned_listing['title'] ?? 'Your item';
    } else {
        $_SESSION['success'] = "Listing marked " . strtolower(loop_pretty_status($status)) . ".";
    }
} else {
    $_SESSION['listing_error'] = "Listing status could not be updated.";
}

$stmt->close();
$conn->close();
header("Location: " . $redirect_path);
exit();
?>
