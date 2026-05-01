
<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

$username = isset($_SESSION['registered_username'])
    ? htmlspecialchars($_SESSION['registered_username'], ENT_QUOTES, 'UTF-8')
    : "there";

include("../backend/db_connect.php");
require_once("../backend/recommendations.php");

$user_id = loop_user_id();
$user_interests = loop_get_user_interests($conn, $user_id);
$saved_listing_count = loop_get_saved_listing_count($conn, $user_id);
$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Dashboard</title>
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
              <h3><a class="active" href="dashboard.php">Dashboard</a></h3>
              <h3><a href="marketplace.php">Marketplace</a></h3>
              <h3><a href="create_post.php">Create Listing</a></h3>
              <h3><a href="profile.php">Profile</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <div class="dashboard-welcome">
              <p class="eyebrow">Campus circular marketplace</p>
              <h1>Welcome back, <?php echo $username; ?></h1>
              <p>
                Loop helps TU Dublin students sell, swap, borrow, donate, and give away
                useful items across campus.
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
              <p class="eyebrow">Start here</p>
              <h2>Quick Actions</h2>
            </div>
          </div>
          <div class="quick-action-grid">
            <a class="quick-action" href="create_post.php">
              <strong>Create Listing</strong>
              <span>Offer something to sell, swap, donate, lend, or give away.</span>
            </a>
            <a class="quick-action" href="marketplace.php">
              <strong>Browse Marketplace</strong>
              <span>Find second-hand items from students on your campus.</span>
            </a>
            <a class="quick-action" href="profile.php">
              <strong>Edit Profile</strong>
              <span>Keep your account ready for interests and recommendations.</span>
            </a>
            <div class="quick-action quick-action-muted">
              <strong>Set Interests</strong>
              <span>Interest choices will help Loop personalise your marketplace later.</span>
            </div>
          </div>
        </section>

        <section class="card dashboard-section dashboard-profile-prompt">
          <div>
            <p class="eyebrow">Personalise your Loop</p>
            <h2>Your Interests</h2>
            <?php if (empty($user_interests)) { ?>
              <p>Choose interests in your profile to personalise your marketplace.</p>
            <?php } else { ?>
              <p>
                Your marketplace is tuned for:
                <?php echo htmlspecialchars(implode(", ", $user_interests), ENT_QUOTES, 'UTF-8'); ?>.
              </p>
            <?php } ?>
            <p class="form-note dashboard-saved-line">
              Saved items: <?php echo (int) $saved_listing_count; ?>.
              Save marketplace listings to help Loop learn what to recommend.
            </p>
          </div>
          <a class="btn" href="profile.php">Edit Interests</a>
        </section>

        <section class="card dashboard-section dashboard-teaser">
          <div>
            <p class="eyebrow">Impact teaser</p>
            <h2>Small actions add up.</h2>
            <p>
              Browse the marketplace or create a listing to start building your Loop.
            </p>
          </div>
          <div class="impact-grid impact-grid-compact" aria-label="Sustainability impact preview">
            <article class="impact-card">
              <span>Items reused</span>
              <strong>0</strong>
            </article>
            <article class="impact-card">
              <span>Active swaps</span>
              <strong>0</strong>
            </article>
            <article class="impact-card">
              <span>Waste diverted</span>
              <strong>0 kg</strong>
            </article>
          </div>
        </section>
      </div>
    </main>

    <footer>
      <div class="wrap">Copyright (c) Loop</div>
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
