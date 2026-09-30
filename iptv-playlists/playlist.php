<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
if (empty($_SESSION['user_id'])) { header('Location: auth.php'); exit; }
$s = db()->prepare('SELECT p.*,c.title category_title FROM playlists p JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1'); $s->execute([(int)($_GET['id'] ?? 0)]); $p = $s->fetch();
if (!$p) { http_response_code(404); exit('Плейлист не найден'); }
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($p['title']) ?> — BOMBALA</title><link rel="stylesheet" href="styles.css"></head><body class="auth-page"><main class="access-card"><a class="back" href="index.php">← К каталогу</a><p class="eyebrow"><?= e($p['category_title']) ?></p><h1><?= e($p['title']) ?></h1><p><?= e($p['description'] ?? '') ?></p><label>M3U-ссылка для плеера<input id="url" value="<?= e($p['playlist_url']) ?>" readonly></label><button onclick="navigator.clipboard.writeText(document.getElementById('url').value);this.textContent='Ссылка скопирована ✓'">Скопировать ссылку</button></main></body></html>
