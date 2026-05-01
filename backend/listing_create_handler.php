<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: ../templates/landing_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/create_post.php");
    exit();
}

include("db_connect.php");
require_once("recommendations.php");

$title = trim($_POST['listing-title'] ?? "");
$description = trim($_POST['listing-description'] ?? "");
$category = trim($_POST['listing-category'] ?? "");
$listing_type = trim($_POST['listing-type'] ?? "");
$condition = trim($_POST['listing-condition'] ?? "");
$price_input = trim($_POST['listing-price'] ?? "");
$campus = trim($_POST['listing-campus'] ?? "");
$user_id = loop_user_id();
$errors = [];

if ($title === "" || strlen($title) > 120) {
    $errors[] = "Please enter a title under 120 characters.";
}

if ($description === "") {
    $errors[] = "Please enter a description.";
}

if (!in_array($category, loop_categories(), true)) {
    $errors[] = "Please select a valid category.";
}

if (!in_array($listing_type, loop_listing_types(), true)) {
    $errors[] = "Please select a valid listing type.";
}

if (!in_array($condition, loop_conditions(), true)) {
    $errors[] = "Please select a valid condition.";
}

if (!in_array($campus, loop_campuses(), true)) {
    $errors[] = "Please select a valid campus.";
}

$price = null;
if (in_array($listing_type, ["free", "donation"], true)) {
    $price = 0;
} elseif ($listing_type === "sell") {
    if ($price_input === "" || !is_numeric($price_input) || (float) $price_input < 0) {
        $errors[] = "Please enter a valid price for sell listings.";
    } else {
        $price = (float) $price_input;
    }
} elseif ($price_input !== "") {
    if (!is_numeric($price_input) || (float) $price_input < 0) {
        $errors[] = "Please enter a valid price or leave it blank.";
    } else {
        $price = (float) $price_input;
    }
}

$image_paths = [
    "Books" => "../assets/listings/books.svg",
    "Course materials" => "../assets/listings/books.svg",
    "Tech & electronics" => "../assets/listings/tech.svg",
    "Clothes" => "../assets/listings/clothes.svg",
    "Furniture" => "../assets/listings/furniture.svg",
    "Kitchen & home" => "../assets/listings/home.svg",
    "Bikes & scooters" => "../assets/listings/other.svg",
    "Music, CDs & vinyl" => "../assets/listings/music.svg",
    "Instruments & audio gear" => "../assets/listings/music.svg",
    "Sports & outdoor" => "../assets/listings/other.svg",
    "Art & design supplies" => "../assets/listings/art.svg",
    "Tools & DIY" => "../assets/listings/other.svg",
    "Gaming" => "../assets/listings/gaming.svg",
    "Other" => "../assets/listings/other.svg"
];
$image_path = $image_paths[$category] ?? "../assets/listings/other.svg";

if (!empty($errors)) {
    $_SESSION['listing_error'] = implode(" ", $errors);
    $conn->close();
    header("Location: ../templates/create_post.php");
    exit();
}

$sql = "INSERT INTO listings
    (user_id, title, description, category, listing_type, item_condition, price, campus, image_path, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['listing_error'] = "Listing could not be saved right now.";
    $conn->close();
    header("Location: ../templates/create_post.php");
    exit();
}

$stmt->bind_param(
    "isssssdss",
    $user_id,
    $title,
    $description,
    $category,
    $listing_type,
    $condition,
    $price,
    $campus,
    $image_path
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Listing created successfully.";
    $stmt->close();
    $conn->close();
    header("Location: ../templates/marketplace.php");
    exit();
}

$_SESSION['listing_error'] = "Listing could not be saved right now.";
$stmt->close();
$conn->close();
header("Location: ../templates/create_post.php");
exit();
?>
