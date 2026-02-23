<?php
    session_start();
    require_once("config.php");

    if(isset($_POST["log"])){
        $username=$_POST["username"];
        $password=$_POST["password"];
        $temp=0;
        // В login.php
        $stmt = $db->prepare("SELECT * FROM users WHERE (username, password) = (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_array($result);
            $_SESSION['username'] = $res['username']; // Сохраняем имя пользователя из БД
            $_SESSION['role'] = $res['role'];
            header('Location: index.php');
            if ($_SESSION['role']=='admin'){
                header('Location:admin-panel.php');
            }
            exit();
        } else {
            $error = 'Пользователя с таким номером телефона не существует!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/auth.css">
    <title>Авторизация</title>
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
        <input id="input" name="username" type="text" placeholder="Введите логин">
        <input id="input" name="password" type="text" placeholder="Введите пароль">
        <input id="login" name="log" type="submit" value="Войти">
        <div class="not-reg">
            <p>Нет аккаунта?</p>
            <a href="register.php">Зарегистрируйтесь</a>
        </div>
    </form>
</body>
</html>