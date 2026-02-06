<?php
    session_start();
    require_once("config.php");

    if(isset($_POST["log"])){
        $phone=$_POST["phone"];
        $temp=0;
        // В login.php
        $stmt = $db->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_array($result);
            $_SESSION['username'] = $res['username']; // Сохраняем имя пользователя из БД
            header('Location: index.php');
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
        <input id="input" name="phone" type="phone" placeholder="Введите номер телефона">
        <input id="login" name="log" type="submit" value="Войти">
        <div class="not-reg">
            <p>Нет аккаунта?</p>
            <a href="register.php">Зарегистрируйтесь</a>
        </div>
    </form>
</body>
</html>