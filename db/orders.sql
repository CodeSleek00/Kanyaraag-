-- MySQL orders table for Kanyaraag
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `user_name` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `pincode` VARCHAR(20) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `quantity` INT NOT NULL,
  `size` VARCHAR(10) NOT NULL,
  `payment_method` ENUM('razorpay','cod') NOT NULL,
  `payment_status` ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `razorpay_payment_id` VARCHAR(100),
  `subtotal` DECIMAL(10,2) NOT NULL,
  `cod_fee` DECIMAL(10,2) DEFAULT 0,
  `total` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES products(`id`)
);
