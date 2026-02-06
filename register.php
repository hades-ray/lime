<?php
session_start();    
require_once("config.php");

if(isset($_POST['reg'])){
    $username=$_POST['username'];
    $phone=$_POST['phone'];
    $stmt = $db->prepare("INSERT INTO users (username, phone, role) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $username, $phone);
    $stmt->execute();
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/auth.css">
    <title>Регистрация</title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
    </header>
    <form class="login" method="post">
        <input id="input" name="phone" type="phone" placeholder="Введите номер телефона">
        <input id="input" name="username" type="text" placeholder="Введите логин">
        <input id="login" name="reg" type="submit" value="Войти">
        <div class="not-reg">
            <p>Есть аккаунт?</p>
            <a href="login.php">Авторизируйтесь</a>
        </div>
    </form>
</body>
</html>