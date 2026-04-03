<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Create</title>
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
          <input
            type="text"
            class="field"
            id="search"
            name="search"
            placeholder="Search listings"
          />
          <button class="btn">Search</button>
        </div>
        <div style="display: flex; gap: 40px">
          <button class="home-variant home-variant-outline" onclick="myFunction()">
            Toggle dark mode
          </button>
          <a class="home-variant home-variant-outline" href="dashboard.php">Home</a>
        </div>
      </div>
    </header>

    <main>
      <!--main section-->
      <div class="wrap">
        <div class="main-row-nav">
          <!--card 1 menu-->
          <div class="card sidebar">
            <h2>Menu</h2>
            <nav>
              <h3><a href="profile.php">Profile</a></h3>
              <h3><a href="create_post.php">Create</a></h3>
              <h3><a href="marketplace.php">Marketplace</a></h3>
            </nav>
          </div>

          <!--card 2 form-->
          <div class="card main-content">
            <h1>Create A Post</h1>
            <p class="hero-copy">
              Simple post form for electronics resale, trade, or wanted items.
            </p>
            <!-- PHP PLACEHOLDER: form should submit to create_post_handler.php -->
            <form action="dashboard.php" method="post" enctype="multipart/form-data">
              <div class="field-group">
                <label for="post-category">Post Category</label>
                <select class="field" id="post-category" name="post-category" required>
                  <option value="">Select a category</option>
                  <option value="sale">For Sale</option>
                  <option value="trade">For Trade</option>
                  <option value="wanted">Wanted</option>
                  <option value="tip">Repair Tip</option>
                </select>
              </div>

              <div class="field-group">
                <label for="post-title">Title</label>
                <input
                  type="text"
                  id="post-title"
                  name="post-title"
                  class="field"
                  placeholder="e.g. 8GB DDR4 RAM for sale"
                  required
                />
              </div>

              <div class="field-group">
                <label for="post-message">Post Message</label>
                <textarea
                  id="post-message"
                  class="field"
                  name="post-message"
                  rows="10"
                  cols="30"
                  placeholder="Include model, condition, and details"
                  required
                ></textarea>
              </div>

              <div class="field-group">
                <label for="post-price">Price (optional)</label>
                <input
                  type="text"
                  class="field"
                  id="post-price"
                  name="post-price"
                  placeholder="e.g. EUR 20"
                />
              </div>

              <div class="field-group">
                <label for="post-image">Upload Item Image</label>
                <input
                  class="field"
                  type="file"
                  id="post-image"
                  name="post-image"
                  accept="image/*"
                />
              </div>

              <button class="btn-submit" type="submit">Post</button>
              <p class="hero-copy">[PHP: success or validation message]</p>
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
