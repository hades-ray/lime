<?php
$db=mysqli_connect("localhost","root","","lime");

if(isset($_POST['reg'])){
    $username=$_POST['username'];
    $phone=$_POST['phone'];
    mysqli_query($db,"INSERT INTO users VALUES ('', '$username', '$phone', 'user')");
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