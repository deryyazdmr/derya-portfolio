CREATE DATABASE IF NOT EXISTS derya_portfolio
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE derya_portfolio;

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS projects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  technologies VARCHAR(255) DEFAULT NULL,
  project_url VARCHAR(255) DEFAULT NULL,
  display_order INT DEFAULT 0,
  is_published TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(180) NOT NULL,
  subject VARCHAR(180) NOT NULL,
  message TEXT NOT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO admins (username, password_hash)
VALUES ('admin', '$2y$10$qx/aW6t8ZwHJM8DlAuyY9OPLvztPEixtLfdCEaPatsr.N2YPUdLYy')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO projects (title, description, technologies, project_url, display_order, is_published)
VALUES
  (
    'Personal Portfolio',
    'A responsive full-stack portfolio with AJAX project loading, PHP form processing and MySQL persistence.',
    'HTML5, CSS3, JavaScript, PHP, MySQL',
    NULL,
    1,
    1
  ),
  (
    'School Communication System',
    'A web application concept for homework tracking, attendance management and parent-teacher communication.',
    'C#, ASP.NET MVC, SQL Server',
    NULL,
    2,
    1
  ),
  (
    'Fire Detection Drone',
    'A software and AI supported drone project idea for faster forest fire detection and emergency reporting.',
    'Python, AI, Embedded Systems',
    NULL,
    3,
    1
  );
