<?php
declare(strict_types=1);

session_start();

const DB_HOST = 'localhost';
const DB_NAME = 'bombalamoy';
const DB_USER = 'bombalamoy_usr';
const DB_PASSWORD = 'ncsIaq01';

function db(): PDO
{
    static $pdo;

    if (!$pdo instanceof PDO) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }

    return $pdo;
}

function isAdmin(): bool
{
    return !empty($_SESSION['admin_id']);
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: admin.php');
        exit;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
