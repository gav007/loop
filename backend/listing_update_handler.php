<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: ../templates/landing_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../templates/my_listings.php");
    exit();
}

include("db_connect.php");
require_once("recommendations.php");

$user_id = loop_user_id();
$listing_id = isset($_POST['listing_id']) ? (int) $_POST['listing_id'] : 0;
$title = trim($_POST['listing-title'] ?? "");
$description = trim($_POST['listing-description'] ?? "");
$category = trim($_POST['listing-category'] ?? "");
$listing_type = trim($_POST['listing-type'] ?? "");
$condition = trim($_POST['listing-condition'] ?? "");
$price_input = trim($_POST['listing-price'] ?? "");
$campus = trim($_POST['listing-campus'] ?? "");
$status = trim($_POST['listing-status'] ?? "");
$errors = [];
$redirect = "../templates/edit_listing.php?id=" . $listing_id;

if ($listing_id <= 0 || $user_id <= 0) {
    $_SESSION['listing_error'] = "Listing could not be found.";
    $conn->close();
    header("Location: ../templates/my_listings.php");
    exit();
}

$existing_stmt = $conn->prepare("SELECT image_path FROM listings WHERE id = ? AND user_id = ? LIMIT 1");

if (!$existing_stmt) {
    $_SESSION['listing_error'] = "Listing could not be loaded right now.";
    $conn->close();
    header("Location: ../templates/my_listings.php");
    exit();
}

$existing_stmt->bind_param("ii", $listing_id, $user_id);
$existing_stmt->execute();
$existing_result = $existing_stmt->get_result();
$existing_listing = $existing_result->fetch_assoc();
$existing_stmt->close();

if (!$existing_listing) {
    $_SESSION['listing_error'] = "Only the listing owner can edit this listing.";
    $conn->close();
    header("Location: ../templates/my_listings.php");
    exit();
}

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

if (!in_array($status, loop_listing_statuses(), true)) {
    $errors[] = "Please select a valid listing status.";
}

$price = null;
if (in_array($listing_type, ["free", "donation"], true)) {
    $price = 0;
} elseif ($listing_type === "sell") {
    $parsed_price = loop_parse_listing_price($price_input);
    if ($parsed_price === null || $parsed_price === false || $parsed_price < 0) {
        $errors[] = "Please enter a valid price for sell listings.";
    } else {
        $price = $parsed_price;
    }
} elseif ($price_input !== "") {
    $parsed_price = loop_parse_listing_price($price_input);
    if ($parsed_price !== false && $parsed_price !== null && $parsed_price >= 0) {
        $price = $parsed_price;
    }
}

$existing_image_path = (string) ($existing_listing['image_path'] ?? "");
$image_path = $existing_image_path;
$image_notice = "";

if ($image_path === "" || loop_is_default_listing_image($image_path)) {
    $image_path = loop_default_listing_image($category);
}

if (isset($_FILES['listing-image']) && $_FILES['listing-image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['listing-image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload failed. Please try an image under 2MB or keep the current image.";
    } else {
        $max_size = 2 * 1024 * 1024;
        $tmp_name = $_FILES['listing-image']['tmp_name'];
        $original_name = $_FILES['listing-image']['name'];
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $allowed_mimes = ["image/jpeg", "image/png", "image/gif", "image/webp"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = $finfo ? finfo_file($finfo, $tmp_name) : "";
        if ($finfo) {
            finfo_close($finfo);
        }

        if ($_FILES['listing-image']['size'] > $max_size) {
            $errors[] = "Image must be 2MB or smaller.";
        } elseif (!in_array($extension, $allowed_extensions, true) || !in_array($mime_type, $allowed_mimes, true)) {
            $errors[] = "Image must be JPG, PNG, GIF, or WebP.";
        } else {
            $upload_dir = __DIR__ . "/../uploads/listings";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $filename = "listing_" . $user_id . "_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;
            $destination = $upload_dir . "/" . $filename;

            if (is_writable($upload_dir) && move_uploaded_file($tmp_name, $destination)) {
                $image_path = "../uploads/listings/" . $filename;
            } else {
                $image_notice = " The new image could not be saved, so Loop kept the current image.";
            }
        }
    }
}

if (!empty($errors)) {
    $_SESSION['listing_error'] = implode(" ", $errors);
    $conn->close();
    header("Location: " . $redirect);
    exit();
}

$sql = "UPDATE listings
        SET title = ?, description = ?, category = ?, listing_type = ?, item_condition = ?,
            price = ?, campus = ?, image_path = ?, status = ?
        WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['listing_error'] = "Listing could not be updated right now.";
    $conn->close();
    header("Location: " . $redirect);
    exit();
}

$stmt->bind_param(
    "sssssdsssii",
    $title,
    $description,
    $category,
    $listing_type,
    $condition,
    $price,
    $campus,
    $image_path,
    $status,
    $listing_id,
    $user_id
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Listing updated." . $image_notice;
    $stmt->close();
    $conn->close();
    header("Location: ../templates/listing_detail.php?id=" . $listing_id);
    exit();
}

$_SESSION['listing_error'] = "Listing could not be updated right now.";
$stmt->close();
$conn->close();
header("Location: " . $redirect);
exit();
?>
