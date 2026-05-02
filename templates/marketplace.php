<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

include("../backend/db_connect.php");
require_once("../backend/recommendations.php");

$user_id = loop_user_id();
$user_interests = loop_get_user_interests($conn, $user_id);
$saved_listing_ids = loop_get_saved_listing_ids($conn, $user_id);
$saved_category_preferences = loop_get_saved_category_preferences($conn, $user_id);
$success = $_SESSION['success'] ?? "";
$listing_error = $_SESSION['listing_error'] ?? "";
unset($_SESSION['success'], $_SESSION['listing_error']);

$search = trim($_GET['search'] ?? "");
$category = trim($_GET['category'] ?? "");
$listing_type = trim($_GET['listing-type'] ?? "");
$condition = trim($_GET['condition'] ?? "");
$price_filter = trim($_GET['price'] ?? "");
$campus = trim($_GET['campus'] ?? "");
$sort = trim($_GET['sort'] ?? "recommended");
$marketplace_redirect = "marketplace.php";
if (!empty($_SERVER['QUERY_STRING'])) {
    $marketplace_redirect .= "?" . $_SERVER['QUERY_STRING'];
}
$has_personalisation = !empty($user_interests) || !empty($saved_category_preferences);

$where = ["status = 'active'"];
$params = [];
$types = "";

if ($search !== "") {
    $where[] = "(title LIKE ? OR description LIKE ?)";
    $search_term = "%" . $search . "%";
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "ss";
}

if ($category !== "" && in_array($category, loop_categories(), true)) {
    $where[] = "category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($listing_type !== "" && in_array($listing_type, loop_listing_types(), true)) {
    $where[] = "listing_type = ?";
    $params[] = $listing_type;
    $types .= "s";
}

if ($condition !== "" && in_array($condition, loop_conditions(), true)) {
    $where[] = "item_condition = ?";
    $params[] = $condition;
    $types .= "s";
}

if ($campus !== "" && in_array($campus, loop_campuses(), true)) {
    $where[] = "campus = ?";
    $params[] = $campus;
    $types .= "s";
}

if ($price_filter === "free") {
    $where[] = "(price = 0 OR listing_type IN ('free', 'donation'))";
} elseif ($price_filter === "under-10") {
    $where[] = "price IS NOT NULL AND price <= 10";
} elseif ($price_filter === "under-25") {
    $where[] = "price IS NOT NULL AND price <= 25";
} elseif ($price_filter === "swap") {
    $where[] = "listing_type = 'swap'";
}

$order_by = "created_at DESC";
if ($sort === "free-first") {
    $order_by = "CASE WHEN price = 0 OR listing_type IN ('free', 'donation') THEN 0 ELSE 1 END, created_at DESC";
} elseif ($sort === "lowest-price") {
    $order_by = "CASE WHEN price IS NULL THEN 1 ELSE 0 END, price ASC, created_at DESC";
}

$sql = "SELECT * FROM listings WHERE " . implode(" AND ", $where) . " ORDER BY " . $order_by;
$stmt = $conn->prepare($sql);
$listings = [];

if ($stmt) {
    if (!empty($params)) {
        $bind_values = [$types];
        foreach ($params as $key => $value) {
            $bind_values[] = &$params[$key];
        }
        call_user_func_array([$stmt, "bind_param"], $bind_values);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['recommendation_score'] = loop_score_listing($row, $user_interests, $saved_category_preferences);
        $row['recommendation_reason'] = loop_recommendation_reason($row, $user_interests, $saved_category_preferences);
        $listings[] = $row;
    }

    $stmt->close();
}

if ($sort === "recommended" && $has_personalisation) {
    usort($listings, function ($a, $b) {
        if ($a['recommendation_score'] === $b['recommendation_score']) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        }

        return $b['recommendation_score'] <=> $a['recommendation_score'];
    });
}

$listing_count = count($listings);
$conn->close();

function selected_attr($value, $current) {
    return $value === $current ? " selected" : "";
}

function safe_text($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function loop_excerpt($value, $length = 130) {
    $text = (string) $value;
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . "...";
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Marketplace</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@400;500;700&family=Poppins:wght@500;600;700&family=Playfair+Display:wght@500;600;700&family=Sora:wght@600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../styles/create.css" />
  </head>
  <body>
    <header>
      <div class="wrap">
        <a class="brand" href="dashboard.php">
          <img src="../assets/favicon.svg" alt="Loop logo" />
          <span class="brand-name">Loop</span>
        </a>
        <div class="header-actions">
          <button class="home-variant home-variant-outline" onclick="myFunction()">
            Toggle dark mode
          </button>
          <a class="home-variant home-variant-outline" href="dashboard.php">Home</a>
          <a class="home-variant home-variant-outline" href="../backend/logout.php">Log Out</a>
        </div>
      </div>
    </header>

    <main>
      <div class="wrap">
        <div class="main-row-nav">
          <section class="card sidebar">
            <h2>Menu</h2>
            <nav>
              <h3><a href="dashboard.php">Dashboard</a></h3>
              <h3><a class="active" href="marketplace.php">Marketplace</a></h3>
              <h3><a href="create_post.php">Create Listing</a></h3>
              <h3><a href="my_listings.php">My Listings</a></h3>
              <h3><a href="profile.php">Profile</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <div class="page-intro">
              <p class="eyebrow">Browse Loop</p>
              <h1>Marketplace</h1>
              <p>
                Find second-hand, free, swap, donation, wanted, and borrow listings from
                TU Dublin students.
              </p>
              <div class="action-row">
                <a class="btn-submit" href="create_post.php">Create Listing</a>
                <a class="btn" href="my_listings.php">My Listings</a>
                <a class="btn" href="dashboard.php">Back to Dashboard</a>
              </div>
            </div>
          </section>
        </div>

        <section class="card marketplace-tools">
          <form class="marketplace-filter-form" action="marketplace.php" method="get">
            <div class="search-bar-container marketplace-search">
              <label class="sr-only" for="marketplace-search">Search marketplace</label>
              <input
                class="field"
                type="search"
                id="marketplace-search"
                name="search"
                placeholder="Search listings, tags, or categories"
                value="<?php echo safe_text($search); ?>"
              />
              <button class="btn" type="submit">Search</button>
            </div>

            <div class="filter-grid">
              <div class="field-group">
                <label for="category">Category</label>
                <select class="field" id="category" name="category">
                  <option value="">Select category</option>
                  <?php foreach (loop_categories() as $option) { ?>
                    <option value="<?php echo safe_text($option); ?>"<?php echo selected_attr($option, $category); ?>>
                      <?php echo safe_text($option); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-type">Listing Type</label>
                <select class="field" id="listing-type" name="listing-type">
                  <option value="">Any type</option>
                  <?php foreach (loop_listing_types() as $option) { ?>
                    <option value="<?php echo safe_text($option); ?>"<?php echo selected_attr($option, $listing_type); ?>>
                      <?php echo safe_text(loop_pretty_listing_type($option)); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="field-group">
                <label for="condition">Condition</label>
                <select class="field" id="condition" name="condition">
                  <option value="">Any condition</option>
                  <?php foreach (loop_conditions() as $option) { ?>
                    <option value="<?php echo safe_text($option); ?>"<?php echo selected_attr($option, $condition); ?>>
                      <?php echo safe_text($option); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="field-group">
                <label for="price">Price</label>
                <select class="field" id="price" name="price">
                  <option value="">Any price</option>
                  <option value="free"<?php echo selected_attr("free", $price_filter); ?>>Free only</option>
                  <option value="under-10"<?php echo selected_attr("under-10", $price_filter); ?>>Under EUR 10</option>
                  <option value="under-25"<?php echo selected_attr("under-25", $price_filter); ?>>Under EUR 25</option>
                  <option value="swap"<?php echo selected_attr("swap", $price_filter); ?>>Swap/trade only</option>
                </select>
              </div>

              <div class="field-group">
                <label for="campus">Campus/Location</label>
                <select class="field" id="campus" name="campus">
                  <option value="">All campuses</option>
                  <?php foreach (loop_campuses() as $option) { ?>
                    <option value="<?php echo safe_text($option); ?>"<?php echo selected_attr($option, $campus); ?>>
                      <?php echo safe_text($option); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="field-group">
                <label for="sort">Sort</label>
                <select class="field" id="sort" name="sort">
                  <option value="recommended"<?php echo selected_attr("recommended", $sort); ?>>Recommended</option>
                  <option value="newest"<?php echo selected_attr("newest", $sort); ?>>Newest</option>
                  <option value="free-first"<?php echo selected_attr("free-first", $sort); ?>>Free first</option>
                  <option value="lowest-price"<?php echo selected_attr("lowest-price", $sort); ?>>Lowest price</option>
                </select>
              </div>
            </div>

            <p class="form-note">
              <?php if (!$has_personalisation) { ?>
                Choose interests or save items to personalise your marketplace.
              <?php } else { ?>
                Recommended sorting is using your profile interests and saved items.
              <?php } ?>
            </p>
          </form>
        </section>

        <section class="card marketplace-results">
          <?php if ($success !== "") { ?>
            <p class="message message-success"><?php echo safe_text($success); ?></p>
          <?php } ?>
          <?php if ($listing_error !== "") { ?>
            <p class="message message-error"><?php echo safe_text($listing_error); ?></p>
          <?php } ?>
          <div class="section-heading">
            <div>
              <p class="eyebrow">Feed</p>
              <h2>Campus Feed</h2>
            </div>
            <span class="status-pill"><?php echo $listing_count; ?> listings</span>
          </div>

          <?php if (!$has_personalisation) { ?>
          <div class="marketplace-feed-hints">
            <div class="empty-state">
              <h3>Recommended listings will appear here.</h3>
              <p>
                Choose interests in your profile or save items and the Recommended sort will
                lift matching categories.
              </p>
            </div>
            <div class="empty-state">
              <h3>Recent listings are still available.</h3>
              <p>
                Use Newest, Free first, or Lowest price to browse without personalisation.
              </p>
            </div>
          </div>
          <?php } ?>

          <div class="listing-grid" aria-label="Marketplace listing results">
            <?php foreach ($listings as $listing) { ?>
              <?php $is_saved = isset($saved_listing_ids[(int) $listing['id']]); ?>
              <article class="listing-card">
                <a class="listing-card-link" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>" aria-label="View <?php echo safe_text($listing['title']); ?>">
                  <div class="listing-card-media">
                    <?php if (!empty($listing['image_path'])) { ?>
                      <img
                        src="<?php echo safe_text($listing['image_path']); ?>"
                        alt="Image for <?php echo safe_text($listing['title']); ?>"
                        loading="lazy"
                        decoding="async"
                      />
                    <?php } ?>
                  </div>
                </a>
                <div class="listing-card-body">
                  <div class="listing-meta-row">
                    <span class="listing-type-badge">
                      <?php echo safe_text(loop_pretty_listing_type($listing['listing_type'])); ?>
                    </span>
                    <span class="status-pill status-<?php echo safe_text($listing['status']); ?>">
                      <?php echo safe_text(ucfirst($listing['status'])); ?>
                    </span>
                    <form class="save-listing-form" action="../backend/saved_listing_handler.php" method="post">
                      <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                      <input type="hidden" name="action" value="<?php echo $is_saved ? "unsave" : "save"; ?>" />
                      <input type="hidden" name="redirect" value="<?php echo safe_text($marketplace_redirect); ?>" />
                      <button
                        class="listing-save-button<?php echo $is_saved ? " is-saved" : ""; ?>"
                        type="submit"
                        aria-pressed="<?php echo $is_saved ? "true" : "false"; ?>"
                      >
                        <?php echo $is_saved ? "Saved" : "Save"; ?>
                      </button>
                    </form>
                  </div>
                  <h3>
                    <a class="listing-title-link" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">
                      <?php echo safe_text($listing['title']); ?>
                    </a>
                  </h3>
                  <dl class="listing-details">
                    <div>
                      <dt>Category</dt>
                      <dd><?php echo safe_text($listing['category']); ?></dd>
                    </div>
                    <div>
                      <dt>Condition</dt>
                      <dd><?php echo safe_text($listing['item_condition']); ?></dd>
                    </div>
                    <div>
                      <dt>Campus</dt>
                      <dd><?php echo safe_text($listing['campus']); ?></dd>
                    </div>
                    <div>
                      <dt>Price</dt>
                      <dd><?php echo safe_text(loop_display_price($listing)); ?></dd>
                    </div>
                  </dl>
                  <p><?php echo safe_text(loop_excerpt($listing['description'])); ?></p>
                  <p class="listing-date">
                    Posted <?php echo safe_text(date("M j, Y", strtotime($listing['created_at']))); ?>
                  </p>
                  <?php if ($listing['recommendation_reason'] !== "") { ?>
                    <p class="recommendation-note">
                      <?php echo safe_text($listing['recommendation_reason']); ?>
                    </p>
                  <?php } ?>
                  <a class="btn listing-view-link" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">
                    View Details
                  </a>
                </div>
              </article>
            <?php } ?>
          </div>

          <?php if (empty($listings)) { ?>
          <div class="empty-state marketplace-empty">
            <h3>Be the first to add something useful.</h3>
            <p>
              Post something to sell, swap, donate, lend, or give away instead of letting it
              sit unused.
            </p>
            <a class="btn-submit" href="create_post.php">Create Listing</a>
          </div>
          <?php } ?>
        </section>
      </div>
    </main>

    <footer>
      <div class="wrap">Copyright (c) Loop</div>
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
