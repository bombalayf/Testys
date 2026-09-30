<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

$categories = ['all' => 'Все', 'tv' => 'ТВ', 'sport' => 'Спорт', 'movies' => 'Кино', 'kids' => 'Детям'];
$category = $_GET['category'] ?? 'all';
$query = trim($_GET['q'] ?? '');
if (!isset($categories[$category])) $category = 'all';

$where = ['is_active = 1'];
$params = [];
if ($category !== 'all') { $where[] = 'category = :category'; $params['category'] = $category; }
if ($query !== '') { $where[] = 'title LIKE :query'; $params['query'] = '%' . $query . '%'; }
$statement = db()->prepare('SELECT * FROM playlists WHERE ' . implode(' AND ', $where) . ' ORDER BY id DESC');
$statement->execute($params);
$playlists = $statement->fetchAll();
?><!doctype html>
<html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>BOMBALA — IPTV плейлисты</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css"></head>
<body><header class="topbar"><a class="brand" href="index.php"><span class="b-logo">B</span><span>BOMBALA<small>IPTV</small></span></a><nav><a href="#catalog">Плейлисты</a><a href="#how">Подключение</a></nav><a class="login" href="admin.php"><?php echo isAdmin() ? 'Панель управления' : '⇥ Войти'; ?></a></header>
<main><section class="hero"><div><p class="eyebrow">● &nbsp; Каталог IPTV</p><h1>Смотри больше.<br><em>Управляй проще.</em></h1><p class="lead">Подборка IPTV-плейлистов для телевидения, спорта, кино и детских каналов. Всё в одном удобном месте.</p><a class="primary" href="#catalog">Смотреть каталог&nbsp; →</a><div class="stats"><span><b>120+</b>плейлистов</span><span><b>4K</b>качество</span><span><b>24/7</b>обновления</span></div></div><div class="screen"><div class="live">● ПРЯМОЙ ЭФИР <b>HD</b></div><div class="grass"></div><div class="score"><small>EUROPEAN LEAGUE</small><strong>BAR 2 <i>:</i> 1 LIV</strong><small>63:27 · 2-й тайм</small></div><aside>1 200+<small>телеканалов</small></aside></div></section>
<section id="catalog" class="catalog"><p class="eyebrow">● &nbsp; Библиотека</p><h2>Популярные <em>плейлисты</em></h2><form class="search" method="get"><input name="q" value="<?= e($query) ?>" placeholder="Поиск плейлистов..."><button>Найти</button></form><div class="categories"><?php foreach ($categories as $key => $label): ?><a class="<?= $category === $key ? 'active' : '' ?>" href="?category=<?= $key ?>&q=<?= urlencode($query) ?>"><?= $label ?></a><?php endforeach; ?></div><p class="found">Найдено <?= count($playlists) ?> плейлистов</p><div class="grid"><?php foreach ($playlists as $playlist): ?><article class="card"><div class="cover" style="background:<?= e($playlist['accent']) ?>"><b><?= e($playlist['icon']) ?></b><span><?= e($playlist['quality']) ?></span></div><div class="card-body"><small><?= e($categories[$playlist['category']]) ?> · <?= (int)$playlist['channels'] ?> каналов</small><h3><?= e($playlist['title']) ?></h3><footer>◉ Обновлён сегодня <b>↙ <?= e($playlist['views']) ?></b></footer></div></article><?php endforeach; ?></div></section>
<section id="how" class="steps"><p class="eyebrow">● &nbsp; Быстрый старт</p><h2>Подключение за <em>3 минуты</em></h2><div><article><b>01</b><h3>Выберите плейлист</h3><p>Найдите подходящий набор каналов в каталоге.</p></article><article><b>02</b><h3>Скопируйте ссылку</h3><p>Откройте карточку и получите M3U-ссылку.</p></article><article><b>03</b><h3>Добавьте в плеер</h3><p>Вставьте ссылку в IPTV-плеер.</p></article></div></section></main><footer class="site-footer">© 2026 BOMBALA · IPTV-плейлисты для личного использования</footer></body></html>
