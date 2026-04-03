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
    <title>Loop | Profile</title>
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
        <div style="display: flex; gap: 40px">
          <button class="home-variant home-variant-outline" onclick="myFunction()">
            Toggle dark mode
          </button>
          <a class="home-variant home-variant-outline" href="dashboard.php">Home</a>
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
            <h1>Edit Profile</h1>
            <!-- PHP PLACEHOLDER: form should submit to profile_update.php -->
            <form action="profile.php" method="post">
              <div class="field-group">
                <label for="profile-username">Username</label>
                <input
                  class="field"
                  type="text"
                  id="profile-username"
                  name="username"
                  placeholder="e.g. gavin_loop"
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
                  required
                />
              </div>

              <div class="field-group">
                <label for="profile-bio">Bio</label>
                <textarea
                  class="field"
                  id="profile-bio"
                  name="bio"
                  rows="5"
                  placeholder="Short bio about your sustainability goals"
                ></textarea>
              </div>

              <button class="btn-submit" type="submit">Save Profile</button>
            </form>

            <p class="hero-copy">[PHP: profile update success/error message]</p>
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
