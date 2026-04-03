<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loop | Marketplace</title>
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
            <h2>Add Listing</h2>
            <!-- PHP PLACEHOLDER: form should submit to marketplace_create.php -->
            <form action="marketplace.php" method="post" enctype="multipart/form-data">
              <div class="field-group">
                <label for="item-name">Item Name</label>
                <input
                  class="field"
                  type="text"
                  id="item-name"
                  name="item-name"
                  placeholder="e.g. Arduino Uno R3"
                  required
                />
              </div>

              <div class="field-group">
                <label for="item-category">Category</label>
                <select class="field" id="item-category" name="item-category" required>
                  <option value="">Select category</option>
                  <option value="parts">Parts</option>
                  <option value="storage">Storage</option>
                  <option value="console">Consoles/Games</option>
                  <option value="tools">Tools</option>
                </select>
              </div>

              <div class="field-group">
                <label for="listing-type">Type</label>
                <select class="field" id="listing-type" name="listing-type" required>
                  <option value="">Select</option>
                  <option value="sale">Sale</option>
                  <option value="trade">Trade</option>
                </select>
              </div>

              <div class="field-group">
                <label for="item-condition">Condition</label>
                <select class="field" id="item-condition" name="item-condition" required>
                  <option value="">Select condition</option>
                  <option value="new">New</option>
                  <option value="good">Good</option>
                  <option value="fair">Fair</option>
                </select>
              </div>

              <div class="field-group">
                <label for="item-price">Price</label>
                <input
                  class="field"
                  type="text"
                  id="item-price"
                  name="item-price"
                  placeholder="e.g. EUR 20 or Trade only"
                  required
                />
              </div>

              <div class="field-group">
                <label for="item-description">Description</label>
                <textarea
                  class="field"
                  id="item-description"
                  name="item-description"
                  rows="5"
                  placeholder="Short description"
                ></textarea>
              </div>

              <div class="field-group">
                <label for="item-image">Item Image</label>
                <input
                  class="field"
                  type="file"
                  id="item-image"
                  name="item-image"
                  accept="image/*"
                />
              </div>

              <button class="btn-submit" type="submit">Post Listing</button>
              <p class="hero-copy">[PHP: success or validation message]</p>
            </form>
          </section>
        </div>
      </div>
    </main>

    <footer>
      <div class="wrap">Copyright (c) Loop</div>
      <script src="../scripts/main.js"></script>
    </footer>
  </body>
</html>
