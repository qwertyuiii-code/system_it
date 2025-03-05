/* Файл: admin.php (Панель администратора) */
<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Проверка, является ли пользователь администратором
$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !$user['is_admin']) {
    die("Доступ запрещен.");
}

// Получение списка пользователей
$stmt = $pdo->query("SELECT id, email, is_admin FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Администратор</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Панель администратора</h1>
    <a href="dashboard.php">Назад к панели управления</a>
    
    <h2>Список пользователей</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['email']); ?> - 
                <?php echo $user['is_admin'] ? 'Администратор' : 'Пользователь'; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>