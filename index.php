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
<body class="index-container">
    <h1>Добро пожаловать в систему управления IT-компанией</h1>
    <div class="index-buttons">
        <form action="dashboard.php" method="get">
            <button type="submit">Перейти в Dashboard</button>
        </form>
        <form action="login.php" method="get">
            <button type="submit">Войти</button>
        </form>
        <form action="register.php" method="get">
            <button type="submit">Регистрация</button>
        </form>

    </div>
</body>
    
</body>
</html>