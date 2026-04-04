<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Landing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@400;500;700&family=Poppins:wght@500;600;700&family=Playfair+Display:wght@500;600;700&family=Sora:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <!-- REPORT: CSS file link (Implementation section). -->
    <link rel="stylesheet" href="../styles/style.css" />
  </head>
  <body>
    <!--Site header-->
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
          <a class="home-variant home-variant-outline" href="register.php">Register</a>
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
              Loop helps people sell, swap, and donate used electronics instead of binning them.
            </p>
          </div>

          <!--card 2 form-->
          <div class="card">
            <h1>Sign In to Loop</h1>
            <!-- Backend can add login success or error messages here later. -->

            <form action="../backend/login_handler.php" method="post">
              <div class="field-group">
                <label for="email">Email</label>
                <input
                  class="field"
                  type="email"
                  id="email"
                  name="email"
                  placeholder="Enter your Loop email"
                  required
                />
                <p class="hero-copy"></p>
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
                <p class="hero-copy"></p>
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
    </footer>
    <script src="../scripts/main.js"></script>
  </body>
</html>
