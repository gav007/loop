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
$listing_error = $_SESSION['listing_error'] ?? "";
$success = $_SESSION['success'] ?? "";
unset($_SESSION['listing_error'], $_SESSION['success']);

function edit_text($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function edit_selected($current, $value) {
    return $current === $value ? " selected" : "";
}

$listing = null;

if ($listing_id > 0 && $user_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM listings WHERE id = ? AND user_id = ? LIMIT 1");

    if ($stmt) {
        $stmt->bind_param("ii", $listing_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $listing = $result->fetch_assoc();
        $stmt->close();
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Edit Listing</title>
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
            <?php if ($listing_error !== "") { ?>
              <p class="message message-error"><?php echo edit_text($listing_error); ?></p>
            <?php } ?>
            <?php if ($success !== "") { ?>
              <p class="message message-success"><?php echo edit_text($success); ?></p>
            <?php } ?>

            <?php if (!$listing) { ?>
              <div class="empty-state">
                <h1>Listing not found</h1>
                <p>This listing may not exist, or it may belong to another user.</p>
                <a class="btn" href="my_listings.php">Back to My Listings</a>
              </div>
            <?php } else { ?>
              <div class="page-intro edit-listing-heading">
                <p class="eyebrow">Owner tools</p>
                <h1>Edit Listing</h1>
                <p>Update the item details, replace the image, or change its current status.</p>
              </div>

              <div class="edit-listing-preview">
                <div class="listing-detail-media">
                  <?php if (!empty($listing['image_path'])) { ?>
                    <img
                      src="<?php echo edit_text($listing['image_path']); ?>"
                      alt="Current image for <?php echo edit_text($listing['title']); ?>"
                    />
                  <?php } ?>
                </div>
                <div>
                  <h2><?php echo edit_text($listing['title']); ?></h2>
                  <p class="form-note">
                    Current status:
                    <span class="status-pill status-<?php echo edit_text($listing['status']); ?>">
                      <?php echo edit_text(loop_pretty_status($listing['status'])); ?>
                    </span>
                  </p>
                  <div class="action-row">
                    <a class="btn" href="listing_detail.php?id=<?php echo (int) $listing['id']; ?>">View Listing</a>
                    <a class="btn" href="my_listings.php">Back to My Listings</a>
                  </div>
                </div>
              </div>

              <form action="../backend/listing_update_handler.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="listing_id" value="<?php echo (int) $listing['id']; ?>" />

                <div class="field-group">
                  <label for="listing-title">Title</label>
                  <input
                    type="text"
                    id="listing-title"
                    name="listing-title"
                    class="field"
                    value="<?php echo edit_text($listing['title']); ?>"
                    required
                  />
                </div>

                <div class="field-group">
                  <label for="listing-category">Category</label>
                  <select class="field" id="listing-category" name="listing-category" required>
                    <option value="">Select a category</option>
                    <?php foreach (loop_categories() as $option) { ?>
                      <option value="<?php echo edit_text($option); ?>"<?php echo edit_selected($listing['category'], $option); ?>>
                        <?php echo edit_text($option); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="field-group">
                  <label for="listing-type">Listing Type</label>
                  <select class="field" id="listing-type" name="listing-type" required>
                    <option value="">Select listing type</option>
                    <?php foreach (loop_listing_types() as $option) { ?>
                      <option value="<?php echo edit_text($option); ?>"<?php echo edit_selected($listing['listing_type'], $option); ?>>
                        <?php echo edit_text(loop_pretty_listing_type($option)); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="field-group">
                  <label for="listing-condition">Condition</label>
                  <select class="field" id="listing-condition" name="listing-condition" required>
                    <option value="">Select condition</option>
                    <?php foreach (loop_conditions() as $option) { ?>
                      <option value="<?php echo edit_text($option); ?>"<?php echo edit_selected($listing['item_condition'], $option); ?>>
                        <?php echo edit_text($option); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="field-group">
                  <label for="listing-description">Description</label>
                  <textarea
                    id="listing-description"
                    class="field"
                    name="listing-description"
                    rows="7"
                    required
                  ><?php echo edit_text($listing['description']); ?></textarea>
                </div>

                <div class="field-group">
                  <label for="listing-price">Price or Exchange Details</label>
                  <input
                    type="text"
                    class="field"
                    id="listing-price"
                    name="listing-price"
                    value="<?php echo $listing['price'] === null ? "" : edit_text($listing['price']); ?>"
                  />
                  <p class="form-note">Use a number for sell listings. Free and donation listings will stay EUR 0.</p>
                </div>

                <div class="field-group">
                  <label for="listing-campus">Campus</label>
                  <select class="field" id="listing-campus" name="listing-campus" required>
                    <option value="">Select campus</option>
                    <?php foreach (loop_campuses() as $option) { ?>
                      <option value="<?php echo edit_text($option); ?>"<?php echo edit_selected($listing['campus'], $option); ?>>
                        <?php echo edit_text($option); ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="field-group">
                  <label for="listing-status">Status</label>
                  <select class="field" id="listing-status" name="listing-status" required>
                    <?php foreach (loop_listing_statuses() as $option) { ?>
                      <option value="<?php echo edit_text($option); ?>"<?php echo edit_selected($listing['status'], $option); ?>>
                        <?php echo edit_text(loop_pretty_status($option)); ?>
                      </option>
                    <?php } ?>
                  </select>
                  <p class="form-note">Use Reused when an item has been collected, donated, swapped, or otherwise completed.</p>
                </div>

                <div class="field-group">
                  <label for="listing-image">Replace Item Image</label>
                  <input
                    class="field"
                    type="file"
                    id="listing-image"
                    name="listing-image"
                    accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
                  />
                  <p class="form-note">Optional. JPG, PNG, GIF, or WebP. Max 2MB. Leave blank to keep the current image.</p>
                </div>

                <button class="btn-submit" type="submit">Save Changes</button>
              </form>
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
