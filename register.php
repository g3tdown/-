<?php
session_start();
$db = new PDO('sqlite:'.__DIR__.'/data/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $name = trim($_POST['name'] ?? '');

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Неверный email';
  if(strlen($password) < 6) $errors[] = 'Пароль минимум 6 символов';
  if($name === '') $errors[] = 'Укажите имя';

  if(empty($errors)){
    // проверим, есть ли пользователь
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if($stmt->fetch()){
      $errors[] = 'Пользователь с таким email уже существует';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $db->prepare('INSERT INTO users (email, password, name) VALUES (?, ?, ?)');
      $stmt->execute([$email, $hash, $name]);
      // авторизуем
      $id = $db->lastInsertId();
      $_SESSION['user'] = ['id'=>$id, 'email'=>$email, 'name'=>$name];
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
  <title>Регистрация — Скуфуслуги</title>
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
      <h2>Регистрация</h2>
      <?php if($errors): ?>
        <div class="errors">
          <?php foreach($errors as $e): ?>
            <div class="error"><?=htmlspecialchars($e)?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <form method="post" novalidate>
        <label>Имя
          <input type="text" name="name" required value="<?=htmlspecialchars($_POST['name'] ?? '')?>">
        </label>
        <label>Email
          <input type="email" name="email" required value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
        </label>
        <label>Пароль
          <input type="password" name="password" required>
        </label>
        <div class="form-actions">
          <button class="btn" type="submit">Зарегистрироваться</button>
          <a href="login.php" class="ghost link">Уже есть аккаунт?</a>
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
