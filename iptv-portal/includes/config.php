<?php
declare(strict_types=1);

const DB_HOST = 'localhost';
const DB_NAME = 'bombalamoy_usr';
const DB_USER = 'bombalamoy';
const DB_PASS = 'ncsIaq01';
const APP_NAME = 'Bombala IPTV';
const PLAYLIST_STORAGE = __DIR__ . '/../uploads';

session_start();

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

function user(): ?array { return $_SESSION['user'] ?? null; }
function logged_in(): bool { return user() !== null; }
function is_admin(): bool { return logged_in() && (bool) user()['is_admin']; }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function verify_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid form token.'); } }
function require_login(): void { if (!logged_in()) redirect('/login.php?next=' . urlencode($_SERVER['REQUEST_URI'])); }
function require_admin(): void { if (!is_admin()) redirect('/login.php'); }
