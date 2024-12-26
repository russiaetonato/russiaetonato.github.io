<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Получение товаров из корзины
$cart_items = [];
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);
    $cart_items = $stmt->fetchAll();
}

// Обработка оформления заказа
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total_amount = array_sum(array_map(function($item) {
        return $item['price'] * $_SESSION['cart'][$item['id']];
    }, $cart_items));

    // Создание заказа
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$user_id, $total_amount]);
    $order_id = $pdo->lastInsertId();

    // Добавление товаров в заказ
    foreach ($cart_items as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['id'], $_SESSION['cart'][$item['id']], $item['price']]);
    }

    // Очистка корзины
    unset($_SESSION['cart']);

    // Перенаправление на страницу успешного оформления заказа
    header('Location: order_success.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Оформление заказа</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Главная</a></li>
                <li><a href="cart.php">Корзина</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Профиль</a></li>
                    <li><a href="logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="login.php">Войти</a></li>
                    <li><a href="register.php">Зарегистрироваться</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="checkout-container">
            <?php if (empty($cart_items)): ?>
                <p>Ваша корзина пуста.</p>
            <?php else: ?>
                <form method="POST" action="">
                    <h2>Товары в заказе:</h2>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="order-item">
                            <img src="../<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                            <h3><?= $item['name'] ?></h3>
                            <p>Количество: <?= $_SESSION['cart'][$item['id']] ?></p>
                            <p>Цена: <?= $item['price'] ?> руб.</p>
                        </div>
                    <?php endforeach; ?>
                    <div class="order-total">
                        Итого: <?= array_sum(array_map(function($item) { return $item['price'] * $_SESSION['cart'][$item['id']]; }, $cart_items)) ?> руб.
                    </div>
                    <button type="submit">Оформить заказ</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>