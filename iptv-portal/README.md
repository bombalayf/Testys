# Bombala IPTV

PHP/MySQL portal for managing and sharing IPTV playlists.

## Setup

1. Create the MySQL database and tables:
   ```bash
   mysql -u bombalamoy -p bombalamoy_usr < database/schema.sql
   ```
2. Configure database settings in `includes/config.php` (the requested defaults are already present).
3. Run locally with PHP 8.1+:
   ```bash
   php -S localhost:8000
   ```
4. Sign in to `/admin/` with the initial administrator credentials: `bombalayf` / `ncsIaq01`.

> Change the default database and administrator passwords before any production deployment.

## Features

- Registration, sign-in, sign-out and secure password hashing.
- Public catalogue ordered by rating and views, with FREE/VIP categories.
- Playlist detail pages, view counter, rating, protected URL/file downloads.
- Administrator dashboard to create, edit and remove playlists.
