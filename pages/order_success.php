<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Заказ оформлен</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог товаров</a></li>
                <li><a href="login.php">Войти</a></li>
                <li><a href="register.php">Зарегистрироваться</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="success-message">
            <h2>Ваш заказ успешно оформлен!</h2>
            <p>Спасибо за покупку. Мы свяжемся с вами для уточнения деталей.</p>
            <a href="../index.php">Вернуться на главную</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>