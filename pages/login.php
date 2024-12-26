<?php
session_start(); 
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->execute([$email, $role]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; 
    
        
        if ($user['role'] == 'admin') {
            header('Location: admin_orders.php'); 
        } else {
            header('Location: profile.php'); 
        }
        exit;
    }
    } else {
        $error_message = "Неверный email, пароль или роль.";
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .login-container input, .login-container select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-container button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .login-container .error {
            color: red;
            margin-bottom: 10px;
        }

        .login-container .back-link {
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .login-container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Вход</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?= $error_message ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <select name="role" required>
                <option value="user">Пользователь</option>
                <option value="admin">Администратор</option>
            </select>
            <button type="submit">Войти</button>
        </form>
        <a href="../index.php" class="back-link">Вернуться на главную</a>
    </div>
</body>
</html>