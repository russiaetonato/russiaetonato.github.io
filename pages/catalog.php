<?php
session_start();
include '../includes/db.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin_orders.php');
    exit;
}
?>
<?php
session_start();
include '../includes/db.php';


$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();


if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .catalog {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }

        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
        }

        .product-card p {
            font-size: 0.9rem;
            color: #777;
        }

        .product-card .price {
            font-size: 1.1rem;
            color: #4CAF50;
            font-weight: bold;
            margin: 10px 0;
        }

        .product-card button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-card button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <h1>Каталог товаров</h1>
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
        <div class="catalog">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="../<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <div class="price"><?= $product['price'] ?> руб.</div>
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add_to_cart">Добавить в корзину</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>