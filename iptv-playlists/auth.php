<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

if (isAdmin() || !empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }
$mode = ($_GET['mode'] ?? 'login') === 'register' ? 'register' : 'login';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = ($_POST['mode'] ?? '') === 'register' ? 'register' : 'login';
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    if (strlen($username) < 3 || strlen($password) < 8) $error = 'Логин — от 3 символов, пароль — от 8 символов.';
    elseif ($mode === 'register') {
        try { db()->prepare('INSERT INTO users(username,password_hash) VALUES(?,?)')->execute([$username, password_hash($password, PASSWORD_DEFAULT)]); $_SESSION['user_id'] = (int) db()->lastInsertId(); $_SESSION['username'] = $username; header('Location: index.php?welcome=1'); exit; } catch (PDOException $e) { $error = 'Этот логин уже занят.'; }
    } else {
        $s = db()->prepare('SELECT id,username,password_hash,role FROM users WHERE username=? LIMIT 1'); $s->execute([$username]); $user = $s->fetch();
        if ($user && password_verify($password, $user['password_hash'])) { $_SESSION['user_id'] = $user['id']; $_SESSION['username'] = $user['username']; if ($user['role'] === 'admin') $_SESSION['admin_id'] = $user['id']; header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'index.php')); exit; }
        $error = 'Неверный логин или пароль.';
    }
}
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Вход — BOMBALA</title><link rel="stylesheet" href="styles.css"></head><body class="auth-page"><main class="auth-card"><a href="index.php" class="logo"><img src="assets/bombala-logo.png" alt="BOMBALA"></a><div class="tabs"><a class="<?= $mode === 'login' ? 'active' : '' ?>" href="auth.php">Вход</a><a class="<?= $mode === 'register' ? 'active' : '' ?>" href="auth.php?mode=register">Регистрация</a></div><h1><?= $mode === 'login' ? 'С возвращением' : 'Создайте аккаунт' ?></h1><p><?= $mode === 'login' ? 'Войдите, чтобы открыть плейлисты.' : 'Регистрация открывает доступ к плейлистам.' ?></p><form method="post"><input type="hidden" name="mode" value="<?= $mode ?>"><label>Логин<input name="username" autocomplete="username" required></label><label>Пароль<input type="password" name="password" autocomplete="current-password" required></label><?php if ($error): ?><small class="error"><?= e($error) ?></small><?php endif; ?><button>Продолжить →</button></form><a class="back" href="index.php">Вернуться на главную</a></main></body></html>
