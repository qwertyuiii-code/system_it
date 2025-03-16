<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем список проектов пользователя
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll();
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
        <h1>Панель управления</h1>

        <!-- Если нет проектов, показываем кнопку -->
        <?php if (empty($projects)): ?>
            <p>Проекты не найдены.</p>
            <a href="add_project.php" class="button">Добавить проект</a>
        <?php else: ?>
            <h2>Ваши проекты</h2>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <a href="project.php?id=<?php echo $project['id']; ?>">
                            <?php echo htmlspecialchars($project['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
