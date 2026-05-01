<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

$listing_error = $_SESSION['listing_error'] ?? "";
$success = $_SESSION['success'] ?? "";
$old_input = $_SESSION['listing_old'] ?? [];
unset($_SESSION['listing_error'], $_SESSION['success'], $_SESSION['listing_old']);

function old_value($field, $old_input) {
    return htmlspecialchars((string) ($old_input[$field] ?? ""), ENT_QUOTES, 'UTF-8');
}

function old_selected($field, $value, $old_input) {
    return isset($old_input[$field]) && $old_input[$field] === $value ? " selected" : "";
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Create Listing</title>
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
      <!--main section-->
      <div class="wrap">
        <div class="main-row-nav">
          <!--card 1 menu-->
          <div class="card sidebar">
            <h2>Menu</h2>
            <nav>
              <h3><a href="dashboard.php">Dashboard</a></h3>
              <h3><a href="marketplace.php">Marketplace</a></h3>
              <h3><a class="active" href="create_post.php">Create Listing</a></h3>
              <h3><a href="profile.php">Profile</a></h3>
            </nav>
          </div>

          <!--card 2 form-->
          <div class="card main-content">
            <h1>Create Listing</h1>
            <p class="hero-copy">
              Add an item for another student to buy, swap, borrow, claim, or reuse.
            </p>
            <?php if ($listing_error !== "") { ?>
              <p class="message message-error"><?php echo htmlspecialchars($listing_error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php } ?>
            <?php if ($success !== "") { ?>
              <p class="message message-success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php } ?>
            <form action="../backend/listing_create_handler.php" method="post" enctype="multipart/form-data">
              <div class="field-group">
                <label for="listing-title">Title</label>
                <input
                  type="text"
                  id="listing-title"
                  name="listing-title"
                  class="field"
                  placeholder="e.g. textbook bundle, vinyl records, desk lamp"
                  value="<?php echo old_value('listing-title', $old_input); ?>"
                  required
                />
              </div>

              <div class="field-group">
                <label for="listing-category">Category</label>
                <select class="field" id="listing-category" name="listing-category" required>
                  <option value="">Select a category</option>
                  <option value="Books"<?php echo old_selected('listing-category', 'Books', $old_input); ?>>Books</option>
                  <option value="Course materials"<?php echo old_selected('listing-category', 'Course materials', $old_input); ?>>Course materials</option>
                  <option value="Tech &amp; electronics"<?php echo old_selected('listing-category', 'Tech & electronics', $old_input); ?>>Tech &amp; electronics</option>
                  <option value="Clothes"<?php echo old_selected('listing-category', 'Clothes', $old_input); ?>>Clothes</option>
                  <option value="Furniture"<?php echo old_selected('listing-category', 'Furniture', $old_input); ?>>Furniture</option>
                  <option value="Kitchen &amp; home"<?php echo old_selected('listing-category', 'Kitchen & home', $old_input); ?>>Kitchen &amp; home</option>
                  <option value="Bikes &amp; scooters"<?php echo old_selected('listing-category', 'Bikes & scooters', $old_input); ?>>Bikes &amp; scooters</option>
                  <option value="Music, CDs &amp; vinyl"<?php echo old_selected('listing-category', 'Music, CDs & vinyl', $old_input); ?>>Music, CDs &amp; vinyl</option>
                  <option value="Instruments &amp; audio gear"<?php echo old_selected('listing-category', 'Instruments & audio gear', $old_input); ?>>Instruments &amp; audio gear</option>
                  <option value="Sports &amp; outdoor"<?php echo old_selected('listing-category', 'Sports & outdoor', $old_input); ?>>Sports &amp; outdoor</option>
                  <option value="Art &amp; design supplies"<?php echo old_selected('listing-category', 'Art & design supplies', $old_input); ?>>Art &amp; design supplies</option>
                  <option value="Tools &amp; DIY"<?php echo old_selected('listing-category', 'Tools & DIY', $old_input); ?>>Tools &amp; DIY</option>
                  <option value="Gaming"<?php echo old_selected('listing-category', 'Gaming', $old_input); ?>>Gaming</option>
                  <option value="Other"<?php echo old_selected('listing-category', 'Other', $old_input); ?>>Other</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-type">Listing Type</label>
                <select class="field" id="listing-type" name="listing-type" required>
                  <option value="">Select listing type</option>
                  <option value="sell"<?php echo old_selected('listing-type', 'sell', $old_input); ?>>Sell</option>
                  <option value="swap"<?php echo old_selected('listing-type', 'swap', $old_input); ?>>Swap</option>
                  <option value="free"<?php echo old_selected('listing-type', 'free', $old_input); ?>>Free</option>
                  <option value="donation"<?php echo old_selected('listing-type', 'donation', $old_input); ?>>Donation</option>
                  <option value="wanted"<?php echo old_selected('listing-type', 'wanted', $old_input); ?>>Wanted</option>
                  <option value="borrow"<?php echo old_selected('listing-type', 'borrow', $old_input); ?>>Borrow</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-condition">Condition</label>
                <select class="field" id="listing-condition" name="listing-condition" required>
                  <option value="">Select condition</option>
                  <option value="New"<?php echo old_selected('listing-condition', 'New', $old_input); ?>>New</option>
                  <option value="Good"<?php echo old_selected('listing-condition', 'Good', $old_input); ?>>Good</option>
                  <option value="Fair"<?php echo old_selected('listing-condition', 'Fair', $old_input); ?>>Fair</option>
                  <option value="Needs repair"<?php echo old_selected('listing-condition', 'Needs repair', $old_input); ?>>Needs repair</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-description">Description</label>
                <textarea
                  id="listing-description"
                  class="field"
                  name="listing-description"
                  rows="7"
                  placeholder="Include condition, collection details, what you want in return, and anything a student should know."
                  required
                ><?php echo old_value('listing-description', $old_input); ?></textarea>
              </div>

              <div class="field-group">
                <label for="listing-price">Price or Exchange Details</label>
                <input
                  type="text"
                  class="field"
                  id="listing-price"
                  name="listing-price"
                  placeholder="e.g. EUR 20, free, swap for books, borrow for one week"
                  value="<?php echo old_value('listing-price', $old_input); ?>"
                />
              </div>

              <div class="field-group">
                <label for="listing-campus">Campus</label>
                <select class="field" id="listing-campus" name="listing-campus" required>
                  <option value="">Select campus</option>
                  <option value="Grangegorman"<?php echo old_selected('listing-campus', 'Grangegorman', $old_input); ?>>Grangegorman</option>
                  <option value="Aungier Street"<?php echo old_selected('listing-campus', 'Aungier Street', $old_input); ?>>Aungier Street</option>
                  <option value="Bolton Street"<?php echo old_selected('listing-campus', 'Bolton Street', $old_input); ?>>Bolton Street</option>
                  <option value="Blanchardstown"<?php echo old_selected('listing-campus', 'Blanchardstown', $old_input); ?>>Blanchardstown</option>
                  <option value="Tallaght"<?php echo old_selected('listing-campus', 'Tallaght', $old_input); ?>>Tallaght</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-image">Upload Item Image</label>
                <input
                  class="field"
                  type="file"
                  id="listing-image"
                  name="listing-image"
                  accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
                />
                <p class="form-note">Optional. JPG, PNG, GIF, or WebP. Max 2MB.</p>
              </div>

              <button class="btn-submit" type="submit">Post Listing</button>
              <p class="form-note">
                If you skip the image, Loop will use a simple category placeholder.
              </p>
            </form>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <!--footer-->
      <div class="wrap">Copyright (c) Loop</div>
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
