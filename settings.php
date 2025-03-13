<?php
session_start();
require 'config/db.php';

// Проверяем, вошел ли пользователь в систему
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем текущие данные пользователя
$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_name'])) {
        $new_name = trim($_POST['name']);
        if (!empty($new_name)) {
            $stmt = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
            $stmt->execute([$new_name, $_SESSION['user_id']]);
            $_SESSION['success'] = "Имя успешно обновлено!";
            header("Location: settings.php");
            exit;
        } else {
            $_SESSION['error'] = "Имя не может быть пустым!";
        }
    }

    if (isset($_POST['update_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Пароли не совпадают!";
            } else {
                $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user_data = $stmt->fetch();

                if (password_verify($old_password, $user_data['password'])) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $_SESSION['user_id']]);
                    $_SESSION['success'] = "Пароль успешно изменен!";
                    header("Location: settings.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Старый пароль неверный!";
                }
            }
        } else {
            $_SESSION['error'] = "Заполните все поля!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Настройки</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <h2>Изменение имени</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <button type="submit" name="update_name">Обновить имя</button>
        </form>

        <h2>Изменение пароля</h2>
        <form method="POST">
            <input type="password" name="old_password" placeholder="Старый пароль" required>
            <input type="password" name="new_password" placeholder="Новый пароль" required>
            <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
            <button type="submit" name="update_password">Обновить пароль</button>
        </form>

        <a href="dashboard.php">Вернуться в панель управления</a>
    </div>
</body>
</html>
