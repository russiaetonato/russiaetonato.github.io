<?php
session_start();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница - Вкусвилл</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Добро пожаловать в Вкусвилл</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="pages/catalog.php">Каталог товаров</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="pages/profile.php">Личный кабинет</a></li>
                    <li><a href="pages/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="pages/login.php">Войти</a></li>
                    <li><a href="pages/register.php">Зарегистрироваться</a></li>
                   
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>О нас</h2>
            <p>Мы предлагаем свежие и качественные продукты для вашего стола.</p>
        </section>

        <section>
            <h2>Акции</h2>
            <p>Специальные предложения и скидки на наши товары.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>