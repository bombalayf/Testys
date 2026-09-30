<?php
require_once __DIR__ . '/includes/config.php';
$title = 'Каталог · ' . APP_NAME;
$sql = "SELECT p.*, ROUND(COALESCE(AVG(r.stars), 0), 1) rating, COUNT(r.id) rating_count
        FROM playlists p LEFT JOIN ratings r ON r.playlist_id=p.id
        GROUP BY p.id ORDER BY rating DESC, p.views DESC, p.created_at DESC";
$playlists = db()->query($sql)->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">ЛУЧШИЕ ТРАНСЛЯЦИИ</p><h1>IPTV, которое<br>хочется смотреть.</h1><p>Подборка бесплатных и VIP-плейлистов. Находите любимые каналы в пару кликов.</p><a class="button" href="#catalogue">Открыть каталог</a></div><div class="hero-art"><span>▶</span><strong>Тысячи<br>каналов</strong></div></section>
<section id="catalogue" class="catalogue"><div class="section-heading"><div><p class="eyebrow">ВЫБОР ЗРИТЕЛЕЙ</p><h2>Популярные плейлисты</h2></div><span><?= count($playlists) ?> в каталоге</span></div>
<?php if (!$playlists): ?><div class="empty">Плейлистов пока нет. Администратор скоро добавит первые подборки.</div><?php else: ?><div class="grid"><?php foreach ($playlists as $playlist): ?><article class="card"><a class="poster" href="/playlist.php?id=<?= $playlist['id'] ?>"><img src="<?= e($playlist['poster_url']) ?>" alt="<?= e($playlist['title']) ?>"><span class="badge <?= strtolower($playlist['category']) ?>"><?= e($playlist['category']) ?></span></a><div class="card-body"><h3><a href="/playlist.php?id=<?= $playlist['id'] ?>"><?= e($playlist['title']) ?></a></h3><div class="meta"><span class="stars">★ <?= $playlist['rating'] ?: 'Новый' ?></span><span>◉ <?= number_format($playlist['views'], 0, '', ' ') ?></span></div><a class="open-link" href="/playlist.php?id=<?= $playlist['id'] ?>">Открыть плейлист <b>→</b></a></div></article><?php endforeach; ?></div><?php endif; ?></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
