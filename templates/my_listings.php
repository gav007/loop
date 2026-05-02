<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

include("../backend/db_connect.php");
require_once("../backend/recommendations.php");

$user_id = loop_user_id();
$success = $_SESSION['success'] ?? "";
$listing_error = $_SESSION['listing_error'] ?? "";
$reused_celebration = $_SESSION['reused_celebration'] ?? "";
unset($_SESSION['success'], $_SESSION['listing_error'], $_SESSION['reused_celebration']);

function page_text($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function listing_excerpt($value, $length = 120) {
    $text = (string) $value;
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . "...";
}

$listings = [];
$status_counts = array_fill_keys(loop_listing_statuses(), 0);

$sql = "SELECT *
        FROM listings
        WHERE user_id = ?
        ORDER BY
          CASE status
            WHEN 'active' THEN 0
            WHEN 'unavailable' THEN 1
            WHEN 'reused' THEN 2
            WHEN 'archived' THEN 3
            ELSE 4
          END,
          created_at DESC";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
        if (isset($status_counts[$row['status']])) {
            $status_counts[$row['status']]++;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | My Listings</title>
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
              <h3><a href="marketplace.php">Marketplace</a></h3>
              <h3><a href="create_post.php">Create Listing</a></h3>
              <h3><a class="active" href="my_listings.php">My Listings</a></h3>
              <h3><a href="profile.php">Profile</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <?php if ($reused_celebration !== "") { ?>
              <div class="message message-reused">
                <strong>This item found a new home.</strong> "<?php echo page_text($reused_celebration); ?>" has been marked as reused — one more item kept out of the bin.
              </div>
            <?php } ?>
            <?php if ($success !== "" && $reused_celebration === "") { ?>
              <p class="message message-success"><?php echo page_text($success); ?></p>
            <?php } ?>
            <?php if ($listing_error !== "") { ?>
              <p class="message message-error"><?php echo page_text($listing_error); ?></p>
            <?php } ?>

            <div class="page-intro">
              <p class="eyebrow">Owner tools</p>
              <h1>My Listings</h1>
              <p>
                Manage what you have posted, update details, and mark items when they are
                unavailable, reused, or archived.
              </p>
              <div class="action-row">
                <a class="btn-submit" href="create_post.php">Create Listing</a>
                <a class="btn" href="marketplace.php">Browse Marketplace</a>
              </div>
            </div>
          </section>
        </div>

        <section class="card dashboard-section">
          <div class="section-heading">
            <div>
              <p class="eyebrow">Status overview</p>
              <h2>Your Listing Status</h2>
            </div>
            <span class="status-pill"><?php echo count($listings); ?> total</span>
          </div>
          <div class="impact-grid impact-grid-compact">
            <article class="impact-card">
              <span>Active</span>
              <strong><?php echo (int) $status_counts['active']; ?></strong>
            </article>
            <article class="impact-card">
              <span>Reused</span>
              <strong><?php echo (int) $status_counts['reused']; ?></strong>
            </article>
            <article class="impact-card">
              <span>Unavailable/archived</span>
              <strong><?php echo (int) ($status_counts['unavailable'] + $status_counts['archived']); ?></strong>
            </article>
          </div>
        </section>

        <section class="card marketplace-results">
          <div class="section-heading">
            <div>
              <p class="eyebrow">Manage listings</p>
              <h2>Posted by You</h2>
            </div>
          </div>

          <?php if (empty($listings)) { ?>
            <div class="empty-state">
              <h3>No listings yet.</h3>
              <p>Create your first listing and it will appear here for editing and status updates.</p>
              <a class="btn-submit" href="create_post.php">Create Listing</a>
            </div>
          <?php } else { ?>
            <div class="owner-listing-list">
              <?php foreach ($listings as $listing) { ?>
                <article class="owner-listing-card">
                  <a class="owner-listing-media" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">
                    <?php if (!empty($listing['image_path'])) { ?>
                      <img
                        src="<?php echo page_text($listing['image_path']); ?>"
                        alt="Image for <?php echo page_text($listing['title']); ?>"
                        loading="lazy"
                        decoding="async"
                      />
                    <?php } ?>
                  </a>
                  <div class="owner-listing-body">
                    <div class="listing-meta-row">
                      <span class="listing-type-badge">
                        <?php echo page_text(loop_pretty_listing_type($listing['listing_type'])); ?>
                      </span>
                      <span class="status-pill status-<?php echo page_text($listing['status']); ?>">
                        <?php echo page_text(loop_pretty_status($listing['status'])); ?>
                      </span>
                    </div>
                    <h3>
                      <a class="listing-title-link" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">
                        <?php echo page_text($listing['title']); ?>
                      </a>
                    </h3>
                    <dl class="listing-details">
                      <div>
                        <dt>Category</dt>
                        <dd><?php echo page_text($listing['category']); ?></dd>
                      </div>
                      <div>
                        <dt>Campus</dt>
                        <dd><?php echo page_text($listing['campus']); ?></dd>
                      </div>
                      <div>
                        <dt>Price</dt>
                        <dd><?php echo page_text(loop_display_price($listing)); ?></dd>
                      </div>
                      <div>
                        <dt>Posted</dt>
                        <dd><?php echo page_text(date("M j, Y", strtotime($listing['created_at']))); ?></dd>
                      </div>
                    </dl>
                    <p><?php echo page_text(listing_excerpt($listing['description'])); ?></p>
                    <div class="action-row owner-listing-actions">
                      <a class="btn" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">View</a>
                      <a class="btn" href="edit_listing.php?id=<?php echo (int) $listing['id']; ?>">Edit</a>
                      <form action="../backend/listing_status_handler.php" method="post">
                        <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                        <input type="hidden" name="status" value="active" />
                        <input type="hidden" name="redirect" value="my_listings.php" />
                        <button class="btn" type="submit">Active</button>
                      </form>
                      <form action="../backend/listing_status_handler.php" method="post">
                        <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                        <input type="hidden" name="status" value="unavailable" />
                        <input type="hidden" name="redirect" value="my_listings.php" />
                        <button class="btn" type="submit">Unavailable</button>
                      </form>
                      <form action="../backend/listing_status_handler.php" method="post">
                        <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                        <input type="hidden" name="status" value="reused" />
                        <input type="hidden" name="redirect" value="my_listings.php" />
                        <button class="btn-submit" type="submit">Reused</button>
                      </form>
                      <form action="../backend/listing_status_handler.php" method="post">
                        <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                        <input type="hidden" name="status" value="archived" />
                        <input type="hidden" name="redirect" value="my_listings.php" />
                        <button class="btn btn-danger" type="submit">Archive</button>
                      </form>
                    </div>
                  </div>
                </article>
              <?php } ?>
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
