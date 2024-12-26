<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; 

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        echo "Пользователь с таким email уже существует.";
    } else {
        try {

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $role]);

            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            echo "Ошибка при регистрации: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Вкусвилл</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .register-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        .register-container h1 {
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .register-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .register-container input, .register-container select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .register-container button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-container button:hover {
            background-color: #45a049;
        }

        .register-container .back-link {
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .register-container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Регистрация</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Имя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <select name="role" required>
                <option value="user">Пользователь</option>
                <option value="admin">Администратор</option>
            </select>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <a href="../index.php" class="back-link">Вернуться на главную</a>
    </div>
</body>
</html>