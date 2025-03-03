/* Файл: task.php (Управление задачей) */
<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Ошибка: задача не найдена.");
}

$task_id = $_GET['id'];

// Получение информации о задаче
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Ошибка: задача не найдена.");
}

// Обновление статуса задачи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $task_id]);
    header("Location: project.php?id=" . $task['project_id']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($task['title']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($task['title']); ?></h1>
    <p>Статус: <?php echo htmlspecialchars($task['status']); ?></p>
    
    <h3>Обновить статус</h3>
    <form method="post">
        <select name="status">
            <option value="todo" <?php if ($task['status'] == 'todo') echo 'selected'; ?>>В планах</option>
            <option value="in_progress" <?php if ($task['status'] == 'in_progress') echo 'selected'; ?>>В процессе</option>
            <option value="done" <?php if ($task['status'] == 'done') echo 'selected'; ?>>Выполнено</option>
        </select>
        <button type="submit">Обновить</button>
    </form>
    
    <a href="project.php?id=<?php echo $task['project_id']; ?>">Назад к проекту</a>
</body>
</html>