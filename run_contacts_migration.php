<?php
/**
 * Run Contact Table Migration
 * Execute this file to create the contacts table
 */

require_once 'config.php';

echo "Creating contacts table...\n";

$conn = getDatabaseConnection();

if (!$conn) {
    die("ERROR: Database connection failed\n");
}

$sql = "
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($conn->query($sql)) {
    echo "SUCCESS: Contacts table created successfully!\n";
} else {
    echo "ERROR: " . $conn->error . "\n";
}

$conn->close();
