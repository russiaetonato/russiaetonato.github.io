<?php
session_start();
include '../includes/db.php';
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin_orders.php');
    exit;
}


if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}


if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']); 
}


$cart_items = [];
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);
    $cart_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .cart-container {
            padding: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .cart-item img {
            max-width: 100px; 
            height: auto; 
            border-radius: 8px; 
            margin-right: 15px; 
        }

        .cart-item input {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        .cart-total {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
        }

        .cart-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .cart-actions button, .cart-actions a.checkout-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .cart-actions button:hover, .cart-actions a.checkout-button:hover {
            background-color: #45a049;
        }

        .cart-actions button[name="clear_cart"] {
            background-color: #f44336;
        }

        .cart-actions button[name="clear_cart"]:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <h1>Корзина</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог товаров</a></li>
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
        <div class="cart-container">
            <?php if (empty($cart_items)): ?>
                <p>Ваша корзина пуста.</p>
            <?php else: ?>
                <form method="POST" action="">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item">
                            <img src="../<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                            <h3><?= $item['name'] ?></h3>
                            <p><?= $item['price'] ?> руб.</p>
                            <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $_SESSION['cart'][$item['id']] ?>" min="1">
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-total">
                        Итого: <?= array_sum(array_map(function($item) { return $item['price'] * $_SESSION['cart'][$item['id']]; }, $cart_items)) ?> руб.
                    </div>
                    <div class="cart-actions">
                        <button type="submit" name="update_cart">Обновить корзину</button>
                        <button type="submit" name="clear_cart">Очистить корзину</button>
                        <a href="checkout.php" class="checkout-button">Оформить заказ</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>