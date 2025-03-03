/* Файл: project.php (Страница проекта) */
<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Ошибка: проект не найден.");
}

$project_id = $_GET['id'];

// Получение информации о проекте
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    die("Ошибка: проект не найден.");
}

// Получение списка задач для проекта
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE project_id = ?");
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($project['name']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($project['name']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
    <a href="dashboard.php">Назад к проектам</a>
    
    <h2>Задачи</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?php echo htmlspecialchars($task['title']) . " - " . htmlspecialchars($task['status']); ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h3>Добавить новую задачу</h3>
    <form method="post" action="add_task.php">
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <input type="text" name="title" placeholder="Название задачи" required>
        <button type="submit">Добавить</button>
    </form>
</body>
</html>