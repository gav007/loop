<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

include("../backend/db_connect.php");
require_once("../backend/recommendations.php");

$listing_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$user_id = loop_user_id();
$success = $_SESSION['success'] ?? "";
$listing_error = $_SESSION['listing_error'] ?? "";
unset($_SESSION['success'], $_SESSION['listing_error']);

function safe_text($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function status_label($status) {
    if ($status === "active") {
        return "Active";
    }

    if ($status === "unavailable") {
        return "Unavailable";
    }

    if ($status === "archived") {
        return "Archived";
    }

    return ucfirst($status);
}

$listing = null;
$is_saved = false;

if ($listing_id > 0) {
    $sql = "SELECT listings.*, users.username AS owner_username
            FROM listings
            LEFT JOIN users ON users.id = listings.user_id
            WHERE listings.id = ?
            LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $listing = $result->fetch_assoc();
        $stmt->close();
    }
}

if ($listing) {
    $is_saved = loop_is_listing_saved($conn, $user_id, (int) $listing['id']);
}

$conn->close();
$is_owner = $listing && (int) $listing['user_id'] === $user_id;
$is_hidden_from_viewer = $listing && $listing['status'] === "archived" && !$is_owner;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Listing Details</title>
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
              <h3><a href="profile.php">Profile</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <?php if ($success !== "") { ?>
              <p class="message message-success"><?php echo safe_text($success); ?></p>
            <?php } ?>
            <?php if ($listing_error !== "") { ?>
              <p class="message message-error"><?php echo safe_text($listing_error); ?></p>
            <?php } ?>

            <?php if (!$listing || $is_hidden_from_viewer) { ?>
              <div class="empty-state">
                <h1>Listing not available</h1>
                <p>This listing may have been removed, archived, or marked unavailable.</p>
                <a class="btn" href="marketplace.php">Back to Marketplace</a>
              </div>
            <?php } else { ?>
              <div class="listing-detail-layout">
                <div class="listing-detail-media">
                  <?php if (!empty($listing['image_path'])) { ?>
                    <img
                      src="<?php echo safe_text($listing['image_path']); ?>"
                      alt="Image for <?php echo safe_text($listing['title']); ?>"
                    />
                  <?php } ?>
                </div>

                <div class="listing-detail-content">
                  <p class="eyebrow">Listing Details</p>
                  <div class="listing-detail-title-row">
                    <h1><?php echo safe_text($listing['title']); ?></h1>
                    <span class="status-pill status-<?php echo safe_text($listing['status']); ?>">
                      <?php echo safe_text(status_label($listing['status'])); ?>
                    </span>
                  </div>

                  <div class="listing-meta-row listing-detail-badges">
                    <span class="listing-type-badge">
                      <?php echo safe_text(loop_pretty_listing_type($listing['listing_type'])); ?>
                    </span>
                    <span class="status-pill"><?php echo safe_text(loop_display_price($listing)); ?></span>
                  </div>

                  <div class="action-row listing-detail-actions">
                    <form class="save-listing-form" action="../backend/saved_listing_handler.php" method="post">
                      <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                      <input type="hidden" name="action" value="<?php echo $is_saved ? "unsave" : "save"; ?>" />
                      <input type="hidden" name="redirect" value="listing_detail.php?id=<?php echo (int) $listing['id']; ?>" />
                      <button
                        class="listing-save-button<?php echo $is_saved ? " is-saved" : ""; ?>"
                        type="submit"
                        aria-pressed="<?php echo $is_saved ? "true" : "false"; ?>"
                        <?php if (!$is_saved && $listing['status'] !== "active") echo "disabled"; ?>
                      >
                        <?php echo $is_saved ? "Saved" : "Save Listing"; ?>
                      </button>
                    </form>
                  </div>

                  <dl class="listing-details listing-detail-facts">
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
                      <dt>Posted</dt>
                      <dd><?php echo safe_text(date("M j, Y", strtotime($listing['created_at']))); ?></dd>
                    </div>
                    <div>
                      <dt>Owner</dt>
                      <dd><?php echo safe_text($listing['owner_username'] ?: "Loop student"); ?></dd>
                    </div>
                  </dl>

                  <section class="listing-detail-section">
                    <h2>Description</h2>
                    <p><?php echo nl2br(safe_text($listing['description'])); ?></p>
                  </section>

                  <section class="listing-detail-section contact-placeholder">
                    <h2>Contact</h2>
                    <p>
                      Contact and messaging are coming soon. For now, use your TU Dublin email
                      and arrange any collection safely on campus.
                    </p>
                  </section>

                  <?php if ($is_owner) { ?>
                    <section class="owner-actions">
                      <h2>Owner Actions</h2>
                      <p class="form-note">
                        These actions only appear for the student who created the listing.
                      </p>
                      <div class="action-row">
                        <form action="../backend/listing_status_handler.php" method="post">
                          <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                          <input type="hidden" name="status" value="active" />
                          <button class="btn" type="submit">Mark Active</button>
                        </form>
                        <form action="../backend/listing_status_handler.php" method="post">
                          <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                          <input type="hidden" name="status" value="unavailable" />
                          <button class="btn" type="submit">Mark Unavailable</button>
                        </form>
                        <form action="../backend/listing_status_handler.php" method="post">
                          <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />
                          <input type="hidden" name="status" value="archived" />
                          <button class="btn btn-danger" type="submit">Archive Listing</button>
                        </form>
                      </div>
                    </section>
                  <?php } ?>

                  <div class="action-row">
                    <a class="btn" href="marketplace.php">Back to Marketplace</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </section>
        </div>
      </div>
    </main>

    <footer>
      <div class="wrap">Copyright (c) Loop</div>
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
