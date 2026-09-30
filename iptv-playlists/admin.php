<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

$error = '';
if (isset($_GET['logout'])) { session_unset(); session_destroy(); header('Location: admin.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $stmt = db()->prepare('SELECT id, password_hash FROM admins WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => trim($_POST['username'] ?? '')]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($_POST['password'] ?? '', $admin['password_hash'])) { $_SESSION['admin_id'] = $admin['id']; header('Location: admin.php'); exit; }
    $error = 'Неверный логин или пароль.';
}
if (isAdmin() && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') { $stmt = db()->prepare('INSERT INTO playlists(title, category, channels, quality, playlist_url) VALUES(:title,:category,:channels,:quality,:url)'); $stmt->execute(['title' => trim($_POST['title']), 'category' => $_POST['category'], 'channels' => (int) $_POST['channels'], 'quality' => trim($_POST['quality']), 'url' => trim($_POST['playlist_url'])]); }
    if ($_POST['action'] === 'delete') { db()->prepare('DELETE FROM playlists WHERE id = :id')->execute(['id' => (int) $_POST['id']]); }
    header('Location: admin.php'); exit;
}
if (!isAdmin()): ?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Вход — BOMBALA</title><link rel="stylesheet" href="styles.css"></head><body class="login-page"><main class="auth"><a class="brand" href="index.php"><span class="b-logo">B</span>BOMBALA</a><h1>Добро пожаловать</h1><p>Войдите в панель управления</p><form method="post"><label>Логин<input name="username" autocomplete="username" required></label><label>Пароль<input name="password" type="password" autocomplete="current-password" required></label><?php if ($error): ?><small class="error"><?= e($error) ?></small><?php endif; ?><button class="primary">Войти в панель →</button></form><a href="index.php">Вернуться на главную</a></main></body></html><?php exit; endif;
$playlists = db()->query('SELECT * FROM playlists ORDER BY id DESC')->fetchAll();
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Админ-панель — BOMBALA</title><link rel="stylesheet" href="styles.css"></head><body><header class="topbar"><a class="brand" href="index.php"><span class="b-logo">B</span>BOMBALA</a><a class="login" href="?logout=1">Выйти</a></header><main class="admin"><p class="eyebrow">● &nbsp; Администрирование</p><h1>Плейлисты</h1><section class="admin-grid"><div class="admin-list"><h2>Все плейлисты</h2><?php foreach ($playlists as $p): ?><div class="admin-row"><span><b><?= e($p['title']) ?></b><small><?= e($p['category']) ?> · <?= (int)$p['channels'] ?> каналов</small></span><form method="post"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="delete">Удалить</button></form></div><?php endforeach; ?></div><form class="add" method="post"><h2>Новый плейлист</h2><input type="hidden" name="action" value="add"><label>Название<input name="title" required></label><label>Категория<select name="category"><option value="tv">ТВ</option><option value="sport">Спорт</option><option value="movies">Кино</option><option value="kids">Детям</option></select></label><label>Количество каналов<input name="channels" type="number" min="1" required></label><label>Качество<input name="quality" value="HD" required></label><label>M3U ссылка<input name="playlist_url" type="url"></label><button class="primary">Добавить плейлист</button></form></section></main></body></html>
