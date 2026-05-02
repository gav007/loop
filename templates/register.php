<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Register</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@400;500;700&family=Poppins:wght@500;600;700&family=Playfair+Display:wght@500;600;700&family=Sora:wght@600;700&display=swap"
      rel="stylesheet"/>

    <link rel="stylesheet" href="../styles/style.css" />
  </head>
  <body>
    <header>
      <div class="wrap">
        <a class="brand" href="landing_page.php">
          <img src="../assets/favicon.svg" alt="Loop logo" />
          <span class="brand-name">Loop</span>
        </a>
        <div class="header-actions">
          <button class="home-variant home-variant-outline" onclick="myFunction()">
            Toggle dark mode
          </button>
          <a class="home-variant home-variant-outline" href="landing_page.php">Home</a>
        </div>
      </div>
    </header>

    <main>
      <!--main section-->
      <div class="wrap">
        <div class="main-row">
          <!--card 1-->
          <div class="card">
            <div class="img-panel">
              <img src="../assets/loop.png" id="hero-logo" class="hero-logo" alt="main-logo" />
            </div>
            <h2 class="hero-tagline">Give campus items a second life.</h2>
            <p class="hero-copy">
              Loop is a TU Dublin community for selling, swapping, borrowing, donating, and
              giving away useful items.
            </p>
            <p class="hero-copy">
              From books and bikes to records, clothes, furniture, and tech, campus items can
              stay in use.
            </p>
            <p class="hero-copy">
              Post clear details so other students can reuse things with confidence.
            </p>
          </div>

          <!--card 2 form-->
          <div class="card">
            <h1>Create Your Loop Account</h1>
            <!-- Backend can add register validation messages here later. -->
            <form
              name="myForm"
              onsubmit="return validatePassword();"
              action="../backend/register_handler.php"
              method="post"
            >
              <div class="field-group">
                <label for="username">Username</label>
                <input
                  class="field"
                  type="text"
                  id="username"
                  name="username"
                  placeholder="e.g. tud123/StudentName"
                  required
                />
                <p class="hero-copy"></p>
              </div>

              <div class="field-group">
                <label for="email">Email</label>
                <input
                  class="field"
                  type="email"
                  id="email"
                  name="email"
                  placeholder="your.name@tudublin.ie"
                  required
                />
                <p class="form-note">TU Dublin email required (@tudublin.ie or @mytudublin.ie)</p>
              </div>

              <div class="field-group">
                <label for="password">Password</label>
                <input
                  class="field"
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Enter password (Min of 8 characters)"
                  required
                  minlength="8"
                />
                <p class="hero-copy"></p>
              </div>

              <div class="field-group">
                <label for="confirm_password">Confirm Password</label>
                <input
                  class="field"
                  type="password"
                  id="confirm_password"
                  name="confirm_password"
                  placeholder="Confirm password"
                  required
                />
                <p class="hero-copy"></p>
              </div>

              <button class="btn-submit" type="submit" id="reg-submit">Create Account</button>
              <p id="notice"></p>
            </form>

            <?php
            if (isset($_SESSION["error"])) {
              echo '<p class="message message-error">' . htmlspecialchars($_SESSION["error"], ENT_QUOTES, 'UTF-8') . '</p>';
              unset($_SESSION["error"]);
            }

            if (isset($_SESSION["success"])) {
              echo '<p class="message message-success">' . htmlspecialchars($_SESSION["success"], ENT_QUOTES, 'UTF-8') . '</p>';
              unset($_SESSION["success"]);
            }
            ?>

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
