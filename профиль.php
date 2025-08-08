<?php
session_start();
if(!isset($_SESSION['user'])){
  header('Location: login.php');
  exit;
}
$db = new PDO('sqlite:'.__DIR__.'/data/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user = $_SESSION['user'];
$errors = $messages = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = trim($_POST['name'] ?? '');
  if($name === '') $errors[] = 'Имя не может быть пустым';
  if(empty($errors)){
    $stmt = $db->prepare('UPDATE users SET name = ? WHERE id = ?');
    $stmt->execute([$name, $user['id']]);
    $_SESSION['user']['name'] = $name;
    $messages[] = 'Профиль обновлён';
  }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Профиль — Скуфуслуги</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="page">
  <header class="site-header">
    <div class="container header-inner">
      <h1 class="brand">Скуфуслуги</h1>
      <nav class="nav">
        <a href="index.php">Главная</a>
        <a href="logout.php" class="btn small">Выход</a>
      </nav>
    </div>
  </header>

  <main class="container main-content">
    <div class="card form-card">
      <h2>Профиль</h2>
      <?php if($messages): ?>
        <div class="messages">
          <?php foreach($messages as $m): ?><div class="message"><?=htmlspecialchars($m)?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if($errors): ?>
        <div class="errors">
          <?php foreach($errors as $e): ?><div class="error"><?=htmlspecialchars($e)?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <label>Email
          <input type="email" value="<?=htmlspecialchars($user['email'])?>" disabled>
        </label>
        <label>Имя
          <input type="text" name="name" required value="<?=htmlspecialchars($user['name'])?>">
        </label>
        <div class="form-actions">
          <button class="btn" type="submit">Сохранить</button>
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
