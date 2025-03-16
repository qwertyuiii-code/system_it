<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система управления IT-компанией</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Добро пожаловать в систему управления IT-компанией</h1>
    <a href="dashboard.php">Перейти в панель управления</a>
    <a href="logout.php">Выйти</a>
</body>
</html>