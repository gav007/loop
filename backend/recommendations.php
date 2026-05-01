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

function loop_score_listing($listing, $interests) {
    $score = 0;

    if (in_array($listing['category'], $interests, true)) {
        $score += 50;
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

function loop_recommendation_reason($listing, $interests) {
    if (in_array($listing['category'], $interests, true)) {
        return "Recommended because you like " . $listing['category'] . ".";
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
