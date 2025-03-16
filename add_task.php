<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['project_id'])) {
    header("Location: dashboard.php");
    exit;
}

$project_id = $_GET['project_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (project_id, title) VALUES (?, ?)");
        $stmt->execute([$project_id, $title]);
        header("Location: project.php?id=" . $project_id);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Добавить задачу</h1>
        <form method="POST">
            <input type="text" name="title" placeholder="Название задачи" required>
            <button type="submit">Создать</button>
        </form>
        <a href="project.php?id=<?php echo $project_id; ?>">Назад</a>
    </div>
</body>
</html>
