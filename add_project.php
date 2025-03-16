<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO projects (user_id, name) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить проект</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Добавить проект</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Название проекта" required>
            <button type="submit">Создать</button>
        </form>
        <a href="dashboard.php">Назад</a>
    </div>
</body>
</html>
