<?php
session_start();
include '../includes/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

   
    if ($action == 'confirm') {
        $status = 'confirmed';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    } else {
        die("Неверное действие.");
    }

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);

   
    header('Location: admin_orders.php');
    exit;
}
?>