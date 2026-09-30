CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(80) NOT NULL UNIQUE,
  slug VARCHAR(80) NOT NULL UNIQUE,
  sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS playlists (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  title VARCHAR(160) NOT NULL,
  description TEXT NULL,
  channels SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  quality VARCHAR(24) NOT NULL DEFAULT 'HD',
  cover_color VARCHAR(24) NOT NULL DEFAULT '#6d4aff',
  playlist_url VARCHAR(2048) NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_playlists_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO users (id, username, password_hash, role) VALUES
(1, 'bombalayf', '$2y$12$..vtV/uVRR8e2svboyZeIeSxYi1S9VUn1CpXqeRcxPVeqviDVRoIq', 'admin');
INSERT IGNORE INTO categories (id, title, slug, sort_order) VALUES
(1, 'Телевидение', 'tv', 10), (2, 'Спорт', 'sport', 20), (3, 'Кино', 'movies', 30), (4, 'Детям', 'kids', 40);
INSERT IGNORE INTO playlists (id, category_id, title, description, channels, quality, cover_color, playlist_url) VALUES
(1, 1, 'Премиум ТВ России', 'Федеральные и тематические телеканалы в высоком качестве.', 278, 'FHD · HD', '#4562d6', 'https://example.com/playlist.m3u'),
(2, 2, 'Sport Live 4K', 'Спортивные трансляции и матчи в прямом эфире.', 96, '4K · FHD', '#b74457', 'https://example.com/sport.m3u'),
(3, 3, 'Кино и сериалы', 'Фильмы, сериалы и развлекательные каналы.', 184, 'FHD · HD', '#7b478b', 'https://example.com/movies.m3u'),
(4, 4, 'Детский мир', 'Безопасные каналы и мультфильмы для детей.', 74, 'HD', '#159a88', 'https://example.com/kids.m3u');
