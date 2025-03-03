/* Файл: dashboard.php (Панель управления) */
<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение информации о пользователе
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Получение списка проектов
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Панель управления</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Панель управления</h2>
    <p>Добро пожаловать, <?php echo htmlspecialchars($user['email']); ?>!</p>
    <a href="logout.php">Выйти</a>
    
    <h3>Список проектов</h3>
    <ul>
        <?php foreach ($projects as $project): ?>
            <li>
                <a href="project.php?id=<?php echo $project['id']; ?>">
                    <?php echo htmlspecialchars($project['name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <h3>Добавить новый проект</h3>
    <form method="post" action="add_project.php">
        <input type="text" name="name" placeholder="Название проекта" required>
        <textarea name="description" placeholder="Описание проекта"></textarea>
        <button type="submit">Создать</button>
    </form>
</body>
</html>
