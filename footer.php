<?php
    session_start();
    require_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/footer.css">
    <title>Контактная информация</title>
</head>
<body>
    <footer>
        <h1>Контактная информация</h1>
        <div class="info">
            <div id="info-left">
                <p>Столкнулись с проблемой? Напишите в <a href="#">поддержку</a></p>
                <p>Или оставьте письмо на <a href="#">почту</a></p>
            </div>
            <div id="info-right">
                <p>Мы в соцсетях</p>
                <a href="#"><img src="img/tg.jpg" alt="тг"></a>
            </div>
        </div>
    </footer>
</body>
</html>