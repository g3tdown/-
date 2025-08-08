<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Скуфуслуги — Главная</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="page">
  <header class="site-header">
    <div class="container header-inner">
      <h1 class="brand">Скуфуслуги</h1>
      <nav class="nav">
        <a href="index.php">Главная</a>
        <a href="услуги.html">Услуги</a>
        <a href="оплата.html">Оплата</a>
        <a href="поддержка.html">Поддержка</a>
        <?php if($user): ?>
          <a href="профиль.php">Профиль</a>
          <a href="logout.php" class="btn small">Выход</a>
        <?php else: ?>
          <a href="login.php" class="btn small">Вход</a>
          <a href="register.php" class="btn small">Регистрация</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container main-content">
    <section class="hero">
      <h2>Добро пожаловать в Скуфуслуги</h2>
      <p>Простой пример сайта с регистрацией, входом и профилем на PHP + SQLite.</p>
      <?php if($user): ?>
        <div class="card">
          <strong>Вы вошли как:</strong> <?= htmlspecialchars($user['email']) ?>
        </div>
      <?php else: ?>
        <div class="card">
          <a href="register.php" class="btn">Создать аккаунт</a>
          <a href="login.php" class="btn ghost">Войти</a>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <p>&copy; 2025 Скуфуслуги</p>
    </div>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
