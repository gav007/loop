CREATE TABLE IF NOT EXISTS saved_listings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  listing_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_saved_listing (user_id, listing_id),
  INDEX idx_saved_user (user_id),
  INDEX idx_saved_listing (listing_id)
);
