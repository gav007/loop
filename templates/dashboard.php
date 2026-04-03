<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != 1) {
    $_SESSION["loginError"] = "You must be logged in to view this page.";
    header("Location: login_page.php");
    exit();
}

$username = "";

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Dashboard</title>
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
        <a class="brand" href="landing_page.php">
          <img src="../assets/favicon.svg" alt="Loop logo" />
          <span class="brand-name">Loop</span>
        </a>
        <div class="search-bar-container">
          <input type="text" class="field" name="search" placeholder="Search posts" />
          <button class="btn" type="button">Search</button>
        </div>
        <div style="display: flex; gap: 40px">
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
              <h3><a href="profile.php">Profile</a></h3>
              <h3><a href="create_post.php">Create</a></h3>
              <h3><a href="marketplace.php">Marketplace</a></h3>
            </nav>
          </section>

          <section class="card main-content">
            <h1>Dashboard</h1>
            <p>
              Welcome back, <?php echo htmlspecialchars($username); ?>. A simple feed for buying, selling, and trading used
              electronics.
            </p>

            <h3>Quick Actions</h3>
            <div class="field-group">
              <a class="btn-submit" href="create_post.php">Create New Post</a>
              <a class="btn" href="profile.php">View Profile</a>
            </div>
          </section>
        </div>

        <!--USE PHP HERE TO INJECT LATEST POSTS FROM THE DATABASE-->
        <div class="main-row">
          <section class="card">
            <h2>Recent Posts</h2>

            <!-- PHP PLACEHOLDER: -->
            <h3>[PHP: post_title]</h3>
            <p>[PHP: post_excerpt]</p>
            <p>[PHP: post_owner] | [PHP: post_date]</p>
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
