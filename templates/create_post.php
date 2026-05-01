<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

$listing_error = $_SESSION['listing_error'] ?? "";
$success = $_SESSION['success'] ?? "";
unset($_SESSION['listing_error'], $_SESSION['success']);
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
                  required
                />
              </div>

              <div class="field-group">
                <label for="listing-category">Category</label>
                <select class="field" id="listing-category" name="listing-category" required>
                  <option value="">Select a category</option>
                  <option value="Books">Books</option>
                  <option value="Course materials">Course materials</option>
                  <option value="Tech &amp; electronics">Tech &amp; electronics</option>
                  <option value="Clothes">Clothes</option>
                  <option value="Furniture">Furniture</option>
                  <option value="Kitchen &amp; home">Kitchen &amp; home</option>
                  <option value="Bikes &amp; scooters">Bikes &amp; scooters</option>
                  <option value="Music, CDs &amp; vinyl">Music, CDs &amp; vinyl</option>
                  <option value="Instruments &amp; audio gear">Instruments &amp; audio gear</option>
                  <option value="Sports &amp; outdoor">Sports &amp; outdoor</option>
                  <option value="Art &amp; design supplies">Art &amp; design supplies</option>
                  <option value="Tools &amp; DIY">Tools &amp; DIY</option>
                  <option value="Gaming">Gaming</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-type">Listing Type</label>
                <select class="field" id="listing-type" name="listing-type" required>
                  <option value="">Select listing type</option>
                  <option value="sell">Sell</option>
                  <option value="swap">Swap</option>
                  <option value="free">Free</option>
                  <option value="donation">Donation</option>
                  <option value="wanted">Wanted</option>
                  <option value="borrow">Borrow</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-condition">Condition</label>
                <select class="field" id="listing-condition" name="listing-condition" required>
                  <option value="">Select condition</option>
                  <option value="New">New</option>
                  <option value="Good">Good</option>
                  <option value="Fair">Fair</option>
                  <option value="Needs repair">Needs repair</option>
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
                ></textarea>
              </div>

              <div class="field-group">
                <label for="listing-price">Price or Exchange Details</label>
                <input
                  type="text"
                  class="field"
                  id="listing-price"
                  name="listing-price"
                  placeholder="e.g. EUR 20, free, swap for books, borrow for one week"
                />
              </div>

              <div class="field-group">
                <label for="listing-campus">Campus</label>
                <select class="field" id="listing-campus" name="listing-campus" required>
                  <option value="">Select campus</option>
                  <option value="Grangegorman">Grangegorman</option>
                  <option value="Aungier Street">Aungier Street</option>
                  <option value="Bolton Street">Bolton Street</option>
                  <option value="Blanchardstown">Blanchardstown</option>
                  <option value="Tallaght">Tallaght</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-image">Upload Item Image</label>
                <input
                  class="field"
                  type="file"
                  id="listing-image"
                  name="listing-image"
                  accept="image/*"
                />
              </div>

              <button class="btn-submit" type="submit">Post Listing</button>
              <p class="form-note">
                Images use safe placeholder artwork for now. Upload handling can come later.
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
