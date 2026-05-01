<?php
function loop_categories() {
    return [
        "Books",
        "Course materials",
        "Tech & electronics",
        "Clothes",
        "Furniture",
        "Kitchen & home",
        "Bikes & scooters",
        "Music, CDs & vinyl",
        "Instruments & audio gear",
        "Sports & outdoor",
        "Art & design supplies",
        "Tools & DIY",
        "Gaming",
        "Other"
    ];
}

function loop_interests() {
    $interests = loop_categories();
    $interests[] = "Free items";
    return $interests;
}

function loop_listing_types() {
    return ["sell", "swap", "free", "donation", "wanted", "borrow"];
}

function loop_conditions() {
    return ["New", "Good", "Fair", "Needs repair"];
}

function loop_campuses() {
    return ["Grangegorman", "Aungier Street", "Bolton Street", "Blanchardstown", "Tallaght"];
}

function loop_user_id() {
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
}

function loop_get_user_interests($conn, $user_id) {
    if ($user_id <= 0) {
        return [];
    }

    $sql = "SELECT interest FROM user_interests WHERE user_id = ? ORDER BY interest ASC";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $interests = [];

    while ($row = $result->fetch_assoc()) {
        $interests[] = $row['interest'];
    }

    $stmt->close();
    return $interests;
}

function loop_get_saved_listing_ids($conn, $user_id) {
    if ($user_id <= 0) {
        return [];
    }

    $sql = "SELECT listing_id FROM saved_listings WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $saved_ids = [];

    while ($row = $result->fetch_assoc()) {
        $saved_ids[(int) $row['listing_id']] = true;
    }

    $stmt->close();
    return $saved_ids;
}

function loop_is_listing_saved($conn, $user_id, $listing_id) {
    if ($user_id <= 0 || $listing_id <= 0) {
        return false;
    }

    $sql = "SELECT id FROM saved_listings WHERE user_id = ? AND listing_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ii", $user_id, $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_saved = $result->num_rows > 0;
    $stmt->close();

    return $is_saved;
}

function loop_get_saved_listing_count($conn, $user_id) {
    if ($user_id <= 0) {
        return 0;
    }

    $sql = "SELECT COUNT(*) AS saved_count FROM saved_listings WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 0;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int) ($row['saved_count'] ?? 0);
}

function loop_get_saved_category_preferences($conn, $user_id) {
    if ($user_id <= 0) {
        return [];
    }

    $sql = "SELECT listings.category, COUNT(*) AS category_count
            FROM saved_listings
            INNER JOIN listings ON listings.id = saved_listings.listing_id
            WHERE saved_listings.user_id = ? AND listings.status = 'active'
            GROUP BY listings.category";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = [];

    while ($row = $result->fetch_assoc()) {
        $categories[$row['category']] = (int) $row['category_count'];
    }

    $stmt->close();
    return $categories;
}

function loop_get_recent_saved_listings($conn, $user_id, $limit = 4) {
    if ($user_id <= 0) {
        return [];
    }

    $limit = max(1, min((int) $limit, 8));
    $sql = "SELECT listings.id, listings.title, listings.category, listings.listing_type,
                   listings.price, listings.campus, saved_listings.created_at AS saved_at
            FROM saved_listings
            INNER JOIN listings ON listings.id = saved_listings.listing_id
            WHERE saved_listings.user_id = ? AND listings.status = 'active'
            ORDER BY saved_listings.created_at DESC
            LIMIT ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("ii", $user_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $listings = [];

    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }

    $stmt->close();
    return $listings;
}

function loop_score_listing($listing, $interests, $saved_categories = []) {
    $score = 0;

    if (in_array($listing['category'], $interests, true)) {
        $score += 50;
    }

    if (isset($saved_categories[$listing['category']])) {
        $score += min(30, 15 + ($saved_categories[$listing['category']] * 5));
    }

    if (
        in_array("Free items", $interests, true) &&
        in_array($listing['listing_type'], ["free", "donation"], true)
    ) {
        $score += 20;
    }

    if ($listing['listing_type'] === "swap") {
        $score += 15;
    }

    $created_at = strtotime($listing['created_at']);
    if ($created_at !== false && $created_at >= strtotime("-72 hours")) {
        $score += 10;
    }

    $score += random_int(0, 5);
    return $score;
}

function loop_recommendation_reason($listing, $interests, $saved_categories = []) {
    if (in_array($listing['category'], $interests, true)) {
        return "Recommended because you like " . $listing['category'] . ".";
    }

    if (isset($saved_categories[$listing['category']])) {
        return "Recommended because you saved " . $listing['category'] . " listings.";
    }

    if (
        in_array("Free items", $interests, true) &&
        in_array($listing['listing_type'], ["free", "donation"], true)
    ) {
        return "Recommended because you like free items.";
    }

    if ($listing['listing_type'] === "swap") {
        return "Recommended because swaps keep items moving.";
    }

    return "";
}

function loop_pretty_listing_type($type) {
    return ucfirst($type);
}

function loop_display_price($listing) {
    if (in_array($listing['listing_type'], ["free", "donation"], true)) {
        return "Free";
    }

    if ($listing['price'] === null || $listing['price'] === "") {
        return ucfirst($listing['listing_type']);
    }

    return "EUR " . number_format((float) $listing['price'], 2);
}
?>
