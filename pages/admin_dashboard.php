<?php
session_start();
include '../includes/db.php';

// Проверка роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Панель администратора</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Главная</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Добро пожаловать, Администратор!</h2>
        <p>Здесь вы можете управлять сайтом.</p>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>