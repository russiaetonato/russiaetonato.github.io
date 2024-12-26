<?php
session_start();
include '../includes/db.php';

// Проверка роли администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Получение всех активных заказов (статус 'pending')
$stmt = $pdo->query("SELECT orders.*, users.name AS user_name FROM orders JOIN users ON orders.user_id = users.id WHERE orders.status = 'pending'");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Активные заказы - Панель администратора</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .orders-container {
            padding: 20px;
        }

        .order {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .order h3 {
            margin-top: 0;
        }

        .order p {
            margin: 5px 0;
        }

        .order-actions {
            margin-top: 10px;
        }

        .order-actions button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .order-actions button[name="action"][value="reject"] {
            background-color: #f44336;
        }

        .order-actions button:hover {
            background-color: #45a049;
        }

        .order-actions button[name="action"][value="reject"]:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <h1>Активные заказы</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="orders-container">
            <h2>Список активных заказов</h2>
            <?php if (empty($orders)): ?>
                <p>Нет активных заказов.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order">
                        <h3>Заказ #<?= $order['id'] ?></h3>
                        <p>Пользователь: <?= $order['user_name'] ?></p>
                        <p>Сумма: <?= $order['total_amount'] ?> руб.</p>
                        <p>Статус: <?= $order['status'] ?></p>
                        <div class="order-actions">
                            <form method="POST" action="update_order_status.php">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button type="submit" name="action" value="confirm">Подтвердить заказ</button>
                                <button type="submit" name="action" value="reject">Отклонить заказ</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Вкусвилл. Все права защищены.</p>
    </footer>
</body>
</html>