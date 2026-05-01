DELETE FROM listings
WHERE user_id = 1
  AND title IN (
    'Networking Fundamentals Textbook',
    'Used 24-inch Monitor',
    'Arduino Starter Kit',
    'Box of Old CDs',
    'Acoustic Guitar',
    'Drum Practice Pad',
    'Desk Chair',
    'Kitchen Pan Set',
    'Winter Jacket',
    'Bike Lock',
    'Graphic Calculator',
    'Laptop Stand',
    'Bluetooth Speaker',
    'Art Supplies Bundle',
    'Course Notes Folder',
    'Free Kettle',
    'Gaming Keyboard',
    'Small Bookshelf',
    'Headphones',
    'Backpack'
  );

INSERT INTO listings
  (user_id, title, description, category, listing_type, item_condition, price, campus, image_path, status, created_at)
VALUES
  (1, 'Networking Fundamentals Textbook', 'Clean copy with light highlighting. Useful for networking modules and revision.', 'Books', 'sell', 'Good', 18.00, 'Grangegorman', '../assets/listings/books.svg', 'active', NOW() - INTERVAL 1 DAY),
  (1, 'Used 24-inch Monitor', 'Older monitor, works well over HDMI. Good for a dorm desk setup.', 'Tech & electronics', 'sell', 'Good', 35.00, 'Aungier Street', '../assets/listings/tech.svg', 'active', NOW() - INTERVAL 2 DAY),
  (1, 'Arduino Starter Kit', 'Starter kit with board, jumper wires, LEDs, sensors, and breadboard.', 'Tech & electronics', 'swap', 'Good', NULL, 'Bolton Street', '../assets/listings/tech.svg', 'active', NOW() - INTERVAL 3 DAY),
  (1, 'Box of Old CDs', 'Mixed rock, pop, and soundtrack CDs. Take the full box if you will use them.', 'Music, CDs & vinyl', 'free', 'Fair', 0.00, 'Grangegorman', '../assets/listings/music.svg', 'active', NOW() - INTERVAL 5 HOUR),
  (1, 'Acoustic Guitar', 'Beginner acoustic guitar. One small mark on the body but sounds fine.', 'Instruments & audio gear', 'sell', 'Fair', 45.00, 'Tallaght', '../assets/listings/music.svg', 'active', NOW() - INTERVAL 4 DAY),
  (1, 'Drum Practice Pad', 'Quiet practice pad for drummers. Good for halls or shared houses.', 'Instruments & audio gear', 'swap', 'Good', NULL, 'Blanchardstown', '../assets/listings/music.svg', 'active', NOW() - INTERVAL 2 HOUR),
  (1, 'Desk Chair', 'Basic desk chair, comfortable enough for study sessions. Collection only.', 'Furniture', 'donation', 'Good', 0.00, 'Grangegorman', '../assets/listings/furniture.svg', 'active', NOW() - INTERVAL 6 DAY),
  (1, 'Kitchen Pan Set', 'Three used pans. Still plenty of life left for student cooking.', 'Kitchen & home', 'sell', 'Fair', 12.00, 'Aungier Street', '../assets/listings/home.svg', 'active', NOW() - INTERVAL 8 DAY),
  (1, 'Winter Jacket', 'Warm winter jacket, size medium. Clean and ready to wear.', 'Clothes', 'sell', 'Good', 20.00, 'Tallaght', '../assets/listings/clothes.svg', 'active', NOW() - INTERVAL 12 HOUR),
  (1, 'Bike Lock', 'Solid D-lock. Selling because I upgraded.', 'Bikes & scooters', 'sell', 'Good', 10.00, 'Grangegorman', '../assets/listings/other.svg', 'active', NOW() - INTERVAL 18 HOUR),
  (1, 'Graphic Calculator', 'Calculator for maths and engineering modules. Includes cover.', 'Course materials', 'sell', 'Good', 28.00, 'Bolton Street', '../assets/listings/books.svg', 'active', NOW() - INTERVAL 7 DAY),
  (1, 'Laptop Stand', 'Foldable laptop stand. Handy for library work.', 'Tech & electronics', 'free', 'Good', 0.00, 'Blanchardstown', '../assets/listings/tech.svg', 'active', NOW() - INTERVAL 30 HOUR),
  (1, 'Bluetooth Speaker', 'Small speaker, battery still okay. Good for a room or studio.', 'Tech & electronics', 'borrow', 'Good', NULL, 'Aungier Street', '../assets/listings/tech.svg', 'active', NOW() - INTERVAL 10 DAY),
  (1, 'Art Supplies Bundle', 'Sketch pads, pencils, markers, and a few unused sheets.', 'Art & design supplies', 'donation', 'Good', 0.00, 'Grangegorman', '../assets/listings/art.svg', 'active', NOW() - INTERVAL 9 HOUR),
  (1, 'Course Notes Folder', 'Printed notes from first year modules. Might help with revision.', 'Course materials', 'free', 'Fair', 0.00, 'Tallaght', '../assets/listings/books.svg', 'active', NOW() - INTERVAL 11 DAY),
  (1, 'Free Kettle', 'Working kettle. Moving out and do not need it anymore.', 'Kitchen & home', 'free', 'Fair', 0.00, 'Bolton Street', '../assets/listings/home.svg', 'active', NOW() - INTERVAL 4 HOUR),
  (1, 'Gaming Keyboard', 'Wired mechanical-style keyboard with working RGB lights.', 'Gaming', 'sell', 'Good', 22.00, 'Blanchardstown', '../assets/listings/gaming.svg', 'active', NOW() - INTERVAL 14 HOUR),
  (1, 'Small Bookshelf', 'Compact shelf, fits beside a desk. Has a few scratches.', 'Furniture', 'donation', 'Fair', 0.00, 'Aungier Street', '../assets/listings/furniture.svg', 'active', NOW() - INTERVAL 13 DAY),
  (1, 'Headphones', 'Over-ear wired headphones. Good for labs or library study.', 'Instruments & audio gear', 'sell', 'Good', 15.00, 'Grangegorman', '../assets/listings/music.svg', 'active', NOW() - INTERVAL 6 HOUR),
  (1, 'Backpack', 'Black backpack with laptop sleeve. Wanted: similar smaller bag.', 'Clothes', 'wanted', 'Good', NULL, 'Tallaght', '../assets/listings/clothes.svg', 'active', NOW() - INTERVAL 15 DAY);
