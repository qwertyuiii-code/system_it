<?php
session_start();
require 'config/db.php';

// Проверяем, вошел ли пользователь в систему
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <h2>Меню</h2>
        <ul>
            <li><a href="project.php">Мои проекты</a></li>
            <li><a href="task.php">Мои задачи</a></li>
            <li><a href="settings.php">Настройки</a></li>
            <li><a href="logout.php" class="logout-btn">Выйти</a></li>
        </ul>
    </div>
</body>
</html>
