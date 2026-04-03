<?php
session_start();

$usernameErr = "";
$emailErr = "";
$passwordErr = "";
$confirmPasswordErr = "";
$username = "";
$email = "";

if (isset($_SESSION["registerUsernameErr"])) {
    $usernameErr = $_SESSION["registerUsernameErr"];
    unset($_SESSION["registerUsernameErr"]);
}

if (isset($_SESSION["registerEmailErr"])) {
    $emailErr = $_SESSION["registerEmailErr"];
    unset($_SESSION["registerEmailErr"]);
}

if (isset($_SESSION["registerPasswordErr"])) {
    $passwordErr = $_SESSION["registerPasswordErr"];
    unset($_SESSION["registerPasswordErr"]);
}

if (isset($_SESSION["registerConfirmPasswordErr"])) {
    $confirmPasswordErr = $_SESSION["registerConfirmPasswordErr"];
    unset($_SESSION["registerConfirmPasswordErr"]);
}

if (isset($_SESSION["registerUsername"])) {
    $username = $_SESSION["registerUsername"];
    unset($_SESSION["registerUsername"]);
}

if (isset($_SESSION["registerEmail"])) {
    $email = $_SESSION["registerEmail"];
    unset($_SESSION["registerEmail"]);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Register</title>
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
              Loop is a community for selling, swapping, and donating used electronics.
            </p>
            <p class="hero-copy">
              From Arduino boards to RAM and old consoles, useful devices can stay in use.
            </p>
            <p class="hero-copy">
              Post clear specs and condition details so others can reuse tech with confidence.
            </p>
          </div>

          <!--card 2 form-->
          <div class="card">
            <h1>Create Your Loop Account</h1>
            <!-- PHP PLACEHOLDER: form should submit to register_handler.php -->
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
                  value="<?php echo htmlspecialchars($username); ?>"
                  placeholder="e.g. tud123/StudentName"
                  required
                />
                <p class="hero-copy"><?php echo htmlspecialchars($usernameErr); ?></p>
              </div>

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
                  placeholder="Enter password (Min of 8 characters)"
                  required
                  minlength="8"
                />
                <p class="hero-copy"><?php echo htmlspecialchars($passwordErr); ?></p>
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
                <p class="hero-copy"><?php echo htmlspecialchars($confirmPasswordErr); ?></p>
              </div>

              <button class="btn-submit" type="submit" id="reg-submit">Create Account</button>
              <p id="notice"></p>
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
