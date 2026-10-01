<?php
$selectedFile = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $selectedFile = basename($_FILES['avatar']['name']);
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bombala IPTV — Настройки профиля</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="site-header">
    <a class="brand" href="/" aria-label="Bombala IPTV — главная">
      <img src="assets/logo.png" width="48" height="48" alt="">
      <span><strong>BOMBALA</strong><em>IPTV</em></span>
    </a>
    <nav aria-label="Основная навигация">
      <a href="#login">Войти</a>
      <a class="registration" href="#register">Регистрация</a>
    </nav>
  </header>

  <main class="page-shell">
    <a class="back-link" href="/">← <span>Назад</span></a>
    <section class="profile-card" aria-labelledby="profile-title">
      <div class="profile-heading">
        <img class="profile-icon" src="assets/logo.png" width="92" height="92" alt="">
        <div>
          <p class="eyebrow">Личный кабинет</p>
          <h1 id="profile-title">Настройки<br>профиля</h1>
        </div>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="field-group">
          <label for="avatar">Аватар</label>
          <input class="file-input" id="avatar" name="avatar" type="file" accept="image/*">
          <label class="file-picker" for="avatar">
            <span class="upload-icon" aria-hidden="true">↑</span>
            <span class="file-copy"><b>Выберите файл</b><small>PNG, JPG или WEBP до 5 МБ</small></span>
            <span class="file-name" data-default="Файл не выбран"><?= $selectedFile ? htmlspecialchars($selectedFile, ENT_QUOTES, 'UTF-8') : 'Файл не выбран' ?></span>
          </label>
        </div>
        <div class="field-group">
          <label for="nickname">Ник</label>
          <input id="nickname" name="nickname" type="text" value="bombalayf" autocomplete="nickname">
        </div>
        <div class="field-group">
          <label for="password">Новый пароль</label>
          <p class="field-hint">Оставьте пустым, чтобы не менять пароль</p>
          <input id="password" name="password" type="password" autocomplete="new-password">
        </div>
        <button class="save-button" type="submit">Сохранить изменения <span>→</span></button>
      </form>
    </section>
  </main>
  <script>
    const avatar = document.querySelector('#avatar');
    const fileName = document.querySelector('.file-name');
    avatar.addEventListener('change', () => {
      fileName.textContent = avatar.files.length ? avatar.files[0].name : fileName.dataset.default;
    });
  </script>
</body>
</html>
