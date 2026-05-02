<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="refresh" content="2.4; url=templates/landing_page.php" />
    <title>Loop</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg" />
    <style>
      * {
        box-sizing: border-box;
      }

      body {
        min-height: 100vh;
        margin: 0;
        display: grid;
        place-items: center;
        background:
          radial-gradient(circle at 50% 45%, rgba(59, 89, 152, 0.16), transparent 34%),
          #f8f7f5;
        font-family: Arial, sans-serif;
        color: #2f477a;
      }

      .splash {
        display: grid;
        justify-items: center;
        gap: 18px;
        text-align: center;
      }

      .loop-mark {
        width: min(260px, 62vw);
        height: auto;
        animation:
          float-loop 1.8s ease-in-out infinite,
          fade-in 0.5s ease-out both;
        filter: drop-shadow(0 18px 24px rgba(31, 53, 97, 0.18));
      }

      .loading-ring {
        width: 54px;
        height: 54px;
        border: 5px solid rgba(59, 89, 152, 0.2);
        border-top-color: #3b5998;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
      }

      .splash p {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0;
      }

      @keyframes float-loop {
        0%,
        100% {
          transform: translateY(0) scale(1);
        }

        50% {
          transform: translateY(-10px) scale(1.03);
        }
      }

      @keyframes fade-in {
        from {
          opacity: 0;
          transform: translateY(12px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>
  <body>
    <main class="splash" aria-label="Opening Loop">
      <img class="loop-mark" src="assets/loop.png" alt="Loop logo" />
      <div class="loading-ring" aria-hidden="true"></div>
      <p>Opening Loop...</p>
    </main>
    <script>
      window.setTimeout(function () {
        window.location.href = "templates/landing_page.php";
      }, 2400);
    </script>
  </body>
</html>
