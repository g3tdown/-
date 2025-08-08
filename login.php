<?php
session_start();
$db = new PDO('sqlite:'.__DIR__.'/data/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Неверный email';

  if(empty($errors)){
    $stmt = $db->prepare('SELECT id,email,password,name FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user || !password_verify($password, $user['password'])){
      $errors[] = 'Неверный логин или пароль';
    } else {
      unset($user['password']);
      $_SESSION['user'] = $user;
      header('Location: профиль.php');
      exit;
    }
  }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Вход — Скуфуслуги</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="page">
  <header class="site-header">
    <div class="container header-inner">
      <h1 class="brand">Скуфуслуги</h1>
      <nav class="nav">
        <a href="index.php">Главная</a>
      </nav>
    </div>
  </header>

  <main class="container main-content">
    <div class="card form-card">
      <h2>Вход</h2>
      <?php if($errors): ?>
        <div class="errors">
          <?php foreach($errors as $e): ?>
            <div class="error"><?=htmlspecialchars($e)?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <form method="post" novalidate>
        <label>Email
          <input type="email" name="email" required value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
        </label>
        <label>Пароль
          <input type="password" name="password" required>
        </label>
        <div class="form-actions">
          <button class="btn" type="submit">Войти</button>
          <a href="register.php" class="ghost link">Создать аккаунт</a>
        </div>
      </form>
    </div>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <p>&copy; 2025 Скуфуслуги</p>
    </div>
  </footer>
</body>
</html>
