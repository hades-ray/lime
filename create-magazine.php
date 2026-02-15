<?php
session_start();    
require_once("config.php");

$username=$_SESSION['username'];

if(isset($_POST['create'])){
    $title=$_POST['title'];
    $description=$_POST['description'];
    $stmt = $db->prepare("INSERT INTO magazine VALUES ('', '$title', '$description', '$username')");
    $stmt->execute();
    header("Location:magazine.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/create-magazine.css">
    <title>Новый магазин</title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
    </header>
    <div class="create">
        <form method="post">
            <input class="input" name="title" type="text" placeholder="Введите название магазина" required>
            <textarea class="input" name="description" placeholder="Введите краткое описание" required></textarea>
            <button name="create" type="submit">Создать магазин</button>
        </form>
    </div>
</body>
</html>