
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
$impact = loop_get_impact_stats($conn);
$conn->close();

$show_onboarding = !empty($_SESSION['show_onboarding']);
unset($_SESSION['show_onboarding']);
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
              <h3><a href="my_listings.php">My Listings</a></h3>
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
            <a class="quick-action" href="my_listings.php">
              <strong>My Listings</strong>
              <span>Edit your posts and mark items unavailable, reused, or archived.</span>
            </a>
            <a class="quick-action" href="marketplace.php">
              <strong>Browse Marketplace</strong>
              <span>Find second-hand items from students on your campus.</span>
            </a>
            <a class="quick-action" href="profile.php">
              <strong>Edit Profile</strong>
              <span>Keep your account ready for interests and recommendations.</span>
            </a>
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
            <p class="eyebrow">Campus impact</p>
            <h2><?php echo (int) $impact['items_reused']; ?> item<?php echo $impact['items_reused'] !== 1 ? "s" : ""; ?> reused across Loop.</h2>
            <p>
              Every listing posted keeps something out of the bin.
            </p>
          </div>
          <div class="impact-grid impact-grid-compact" aria-label="Sustainability impact">
            <article class="impact-card">
              <span>Items reused</span>
              <strong><?php echo (int) $impact['items_reused']; ?></strong>
            </article>
            <article class="impact-card">
              <span>Active swaps</span>
              <strong><?php echo (int) $impact['active_swaps']; ?></strong>
            </article>
            <article class="impact-card">
              <span>Waste diverted</span>
              <strong><?php echo $impact['waste_diverted_kg']; ?> kg</strong>
            </article>
          </div>
        </section>
      </div>
    </main>

    <?php if ($show_onboarding) { ?>
    <div class="onboarding-overlay" id="onboarding-overlay" role="dialog" aria-modal="true" aria-label="Welcome to Loop">
      <div class="onboarding-modal">
        <h2>Welcome to Loop!</h2>
        <p>Loop works best when you tell it what you're into, or post your first item.</p>
        <div class="onboarding-actions">
          <a class="btn-submit" href="profile.php">Set My Interests</a>
          <a class="btn" href="create_post.php">Post Something</a>
        </div>
        <button class="onboarding-skip" onclick="document.getElementById('onboarding-overlay').style.display='none'">Skip for now</button>
      </div>
    </div>
    <?php } ?>

    <footer>
      <div class="wrap">Copyright (c) Loop</div>
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
