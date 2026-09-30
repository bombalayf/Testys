CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS playlists (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(160) NOT NULL,
    category ENUM('tv', 'sport', 'movies', 'kids') NOT NULL DEFAULT 'tv',
    channels SMALLINT UNSIGNED NOT NULL,
    quality VARCHAR(24) NOT NULL DEFAULT 'HD',
    accent VARCHAR(120) NOT NULL DEFAULT 'linear-gradient(135deg,#43328a,#7356cc)',
    icon VARCHAR(12) NOT NULL DEFAULT 'B',
    views VARCHAR(20) NOT NULL DEFAULT 'Новый',
    playlist_url VARCHAR(2048) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO admins (id, username, password_hash) VALUES
(1, 'bombalayf', '$2y$12$..vtV/uVRR8e2svboyZeIeSxYi1S9VUn1CpXqeRcxPVeqviDVRoIq');

INSERT IGNORE INTO playlists (id, title, category, channels, quality, accent, icon, views) VALUES
(1, 'Премиум ТВ России', 'tv', 278, 'FHD · HD', 'linear-gradient(135deg,#293b73,#1a7595)', 'ТВ', '15.2k'),
(2, 'Sport Live 4K', 'sport', 96, '4K · FHD', 'linear-gradient(135deg,#823745,#e67e37)', '⚽', '8.6k'),
(3, 'Кино и сериалы', 'movies', 184, 'FHD · HD', 'linear-gradient(135deg,#49306f,#a35070)', '▶', '11.8k'),
(4, 'Детский мир', 'kids', 74, 'HD', 'linear-gradient(135deg,#0e6981,#26b89a)', '★', '5.3k');
