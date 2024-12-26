<?php
session_start();
include '../includes/db.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin_orders.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Личный кабинет</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Главная</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="profile-info">
            <h2>Ваши данные</h2>
            <p>Имя: <?= $user['name'] ?></p>
            <p>Email: <?= $user['email'] ?></p>
            <p>Адрес: <?= $user['address'] ?></p>
            <p>Телефон: <?= $user['phone'] ?></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>