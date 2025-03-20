<?php
session_start();
require __DIR__ . '/config/db.php'; // Подключение к базе

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем список проектов пользователя
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Панель управления</h1>

        <!-- Кнопка "Добавить проект" всегда отображается -->
        <a href="add_project.php" class="btn">Добавить проект</a>

        <?php if (empty($projects)): ?>
            <p>У вас пока нет проектов.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <strong><?= htmlspecialchars($project['title']) ?></strong>
                        <a href="project.php?id=<?= $project['id'] ?>">Открыть</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
