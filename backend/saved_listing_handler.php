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

function loop_saved_redirect_path() {
    $redirect = $_POST['redirect'] ?? "marketplace.php";

    if (preg_match('/\A(?:marketplace\.php(?:\?[A-Za-z0-9%&=+_.~-]*)?|listing_detail\.php\?id=\d+|profile\.php|dashboard\.php)\z/', $redirect)) {
        return "../templates/" . $redirect;
    }

    return "../templates/marketplace.php";
}

$redirect_path = loop_saved_redirect_path();
$user_id = loop_user_id();
$listing_id = isset($_POST['listing_id']) ? (int) $_POST['listing_id'] : 0;
$action = $_POST['action'] ?? "";

if ($user_id <= 0 || $listing_id <= 0 || !in_array($action, ["save", "unsave"], true)) {
    $_SESSION['listing_error'] = "Saved item action could not be completed.";
    $conn->close();
    header("Location: " . $redirect_path);
    exit();
}

if ($action === "save") {
    $check_stmt = $conn->prepare("SELECT id FROM listings WHERE id = ? AND status = 'active' LIMIT 1");

    if (!$check_stmt) {
        $_SESSION['listing_error'] = "Saved items are not ready yet.";
        $conn->close();
        header("Location: " . $redirect_path);
        exit();
    }

    $check_stmt->bind_param("i", $listing_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $listing_exists = $check_result->num_rows > 0;
    $check_stmt->close();

    if (!$listing_exists) {
        $_SESSION['listing_error'] = "That listing is not available to save.";
        $conn->close();
        header("Location: " . $redirect_path);
        exit();
    }

    $save_stmt = $conn->prepare(
        "INSERT IGNORE INTO saved_listings (user_id, listing_id) VALUES (?, ?)"
    );

    if (!$save_stmt) {
        $_SESSION['listing_error'] = "Saved items are not ready yet.";
        $conn->close();
        header("Location: " . $redirect_path);
        exit();
    }

    $save_stmt->bind_param("ii", $user_id, $listing_id);
    $save_stmt->execute();
    $save_stmt->close();

    $_SESSION['success'] = "Listing saved.";
} else {
    $unsave_stmt = $conn->prepare(
        "DELETE FROM saved_listings WHERE user_id = ? AND listing_id = ?"
    );

    if (!$unsave_stmt) {
        $_SESSION['listing_error'] = "Saved item could not be removed right now.";
        $conn->close();
        header("Location: " . $redirect_path);
        exit();
    }

    $unsave_stmt->bind_param("ii", $user_id, $listing_id);
    $unsave_stmt->execute();
    $unsave_stmt->close();

    $_SESSION['success'] = "Listing removed from saved items.";
}

$conn->close();
header("Location: " . $redirect_path);
exit();
?>
