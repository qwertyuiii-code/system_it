<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$project_id = $_GET['id'];

// Проверяем, есть ли проект
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ? AND user_id = ?");
$stmt->execute([$project_id, $_SESSION['user_id']]);
$project = $stmt->fetch();

if (!$project) {
    die("Проект не найден.");
}

// Получаем задачи
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE project_id = ?");
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($project['name']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($project['name']); ?></h1>

        <!-- Если нет задач, показываем кнопку -->
        <?php if (empty($tasks)): ?>
            <p>Задач пока нет.</p>
            <a href="add_task.php?project_id=<?php echo $project_id; ?>" class="button">Добавить задачу</a>
        <?php else: ?>
            <h2>Список задач</h2>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li><?php echo htmlspecialchars($task['title']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="dashboard.php">Назад</a>
    </div>
</body>
</html>