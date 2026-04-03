<?php
session_start();

$emailErr = "";
$passwordErr = "";
$email = "";
$loginMessage = "";
$loginError = "";

if (isset($_SESSION["loginEmailErr"])) {
    $emailErr = $_SESSION["loginEmailErr"];
    unset($_SESSION["loginEmailErr"]);
}

if (isset($_SESSION["loginPasswordErr"])) {
    $passwordErr = $_SESSION["loginPasswordErr"];
    unset($_SESSION["loginPasswordErr"]);
}

if (isset($_SESSION["loginEmail"])) {
    $email = $_SESSION["loginEmail"];
    unset($_SESSION["loginEmail"]);
}

if (isset($_SESSION["loginMessage"])) {
    $loginMessage = $_SESSION["loginMessage"];
    unset($_SESSION["loginMessage"]);
}

if (isset($_SESSION["loginError"])) {
    $loginError = $_SESSION["loginError"];
    unset($_SESSION["loginError"]);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@400;500;700&family=Poppins:wght@500;600;700&family=Playfair+Display:wght@500;600;700&family=Sora:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="../styles/style.css" />
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
              <img src="../assets/loop.png" class="hero-logo" alt="main-logo" />
            </div>
            <h2 class="hero-tagline">Give old tech a second life.</h2>
            <p class="hero-copy">
              Loop helps users trade and reuse electronics like parts, consoles, and tools.
            </p>
          </div>

          <!--card 2 form-->
          <div class="card">
            <h1>Sign In to Loop</h1>
            <!-- PHP PLACEHOLDER: form should submit to login_handler.php -->
            <?php if ($loginMessage != "") { ?>
              <p class="hero-copy"><?php echo htmlspecialchars($loginMessage); ?></p>
            <?php } ?>

            <?php if ($loginError != "") { ?>
              <p class="hero-copy"><?php echo htmlspecialchars($loginError); ?></p>
            <?php } ?>

            <form action="../backend/login_handler.php" method="post">
              <div class="field-group">
                <label for="email">Email</label>
                <input
                  class="field"
                  type="email"
                  id="email"
                  name="email"
                  value="<?php echo htmlspecialchars($email); ?>"
                  placeholder="Enter your Loop email"
                  required
                />
                <p class="hero-copy"><?php echo htmlspecialchars($emailErr); ?></p>
              </div>

              <div class="field-group">
                <label for="password">Password</label>
                <input
                  class="field"
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Enter password"
                  required
                />
                <p class="hero-copy"><?php echo htmlspecialchars($passwordErr); ?></p>
              </div>

              <button class="btn-submit" type="submit">Sign In</button>
            </form>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <!--footer-->
      <div class="wrap">Copyright (c) Loop</div>
      <script src="../scripts/main.js"></script>
    </footer>
  </body>
</html>
