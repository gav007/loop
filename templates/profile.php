<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header("Location: landing_page.php");
    exit();
}

$username = isset($_SESSION['registered_username'])
    ? htmlspecialchars($_SESSION['registered_username'], ENT_QUOTES, 'UTF-8')
    : "";
$email = isset($_SESSION['registered_email'])
    ? htmlspecialchars($_SESSION['registered_email'], ENT_QUOTES, 'UTF-8')
    : "";

include("../backend/db_connect.php");
require_once("../backend/recommendations.php");

$user_id = loop_user_id();
$selected_interests = loop_get_user_interests($conn, $user_id);
$conn->close();

$profile_error = $_SESSION['profile_error'] ?? "";
$success = $_SESSION['success'] ?? "";
unset($_SESSION['profile_error'], $_SESSION['success']);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Profile</title>
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
              <h3><a class="active" href="profile.php">Profile</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <h1>Profile & Interests</h1>
            <?php if ($profile_error !== "") { ?>
              <p class="message message-error"><?php echo htmlspecialchars($profile_error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php } ?>
            <?php if ($success !== "") { ?>
              <p class="message message-success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php } ?>
            <form action="../backend/profile_update_handler.php" method="post">
              <div class="field-group">
                <label for="profile-username">Username</label>
                <input
                  class="field"
                  type="text"
                  id="profile-username"
                  name="username"
                  placeholder="e.g. gavin_loop"
                  value="<?php echo $username; ?>"
                  readonly
                  required
                />
              </div>

              <div class="field-group">
                <label for="profile-email">Email</label>
                <input
                  class="field"
                  type="email"
                  id="profile-email"
                  name="email"
                  placeholder="Enter your Loop email"
                  value="<?php echo $email; ?>"
                  readonly
                  required
                />
              </div>

              <div class="field-group">
                <span class="form-label">Marketplace Interests</span>
                <p class="form-note">
                  Choose what you care about. Recommended sorting uses these interests first.
                </p>
                <div class="interest-grid">
                  <?php foreach (loop_interests() as $interest) { ?>
                    <label class="interest-option">
                      <input
                        type="checkbox"
                        name="interests[]"
                        value="<?php echo htmlspecialchars($interest, ENT_QUOTES, 'UTF-8'); ?>"
                        <?php if (in_array($interest, $selected_interests, true)) echo "checked"; ?>
                      />
                      <span><?php echo htmlspecialchars($interest, ENT_QUOTES, 'UTF-8'); ?></span>
                    </label>
                  <?php } ?>
                </div>
              </div>

              <button class="btn-submit" type="submit">Save Interests</button>
              <p class="form-note">
                Account editing can be expanded later. This phase saves interests only.
              </p>
            </form>
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
