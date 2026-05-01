CREATE TABLE IF NOT EXISTS listings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  category VARCHAR(80) NOT NULL,
  listing_type VARCHAR(30) NOT NULL,
  item_condition VARCHAR(40) NOT NULL,
  price DECIMAL(8,2) NULL,
  campus VARCHAR(80) NOT NULL,
  image_path VARCHAR(255) NULL,
  status VARCHAR(30) DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_interests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  interest VARCHAR(80) NOT NULL,
  weight INT DEFAULT 50,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_user_interest (user_id, interest)
);
