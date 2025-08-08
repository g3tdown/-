<?php
// Запустить этот файл один раз для создания базы данных
$dbFile = __DIR__ . '/data/database.sqlite';
if(file_exists($dbFile)){
  echo "База данных уже существует: " . htmlspecialchars($dbFile);
  exit;
}
$db = new PDO('sqlite:' . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL,
  name TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');
echo "Создана база данных: " . htmlspecialchars($dbFile) . "<br>";
echo "Вы можете удалить init_db.php после первого запуска по соображениям безопасности.";
