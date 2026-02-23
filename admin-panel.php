<?php
    session_start();
    require_once("config.php");

    $isLoggedIn = isset($_SESSION['username']);
    $username = $isLoggedIn ? $_SESSION['username'] : '';
    
    if(isset($_POST['create-categories'])){
        $title=$_POST['title'];

        $check = $db->prepare("SELECT id FROM categories WHERE title = ?");
        $check->bind_param("s", $title);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows == 0) {
        // Сохраняем пользователя
        $stmt = $db->prepare("INSERT INTO categories (title) VALUES (?)");
        $stmt->bind_param("s", $title);

        if($stmt->execute()){
            $title_id= $stmt->insert_id;
            header('Location: admin-panel.php');
            exit();
        }
        } else {
            echo "Такая категория уже существует";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/admin-panel.css">
    <title>Панель администратора</title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
        <p>Панель администратора</p>
    </header>
    <div class="user-info">
        <div class="info-left">
            <div class="avatar-container">
                <img src="uploads/avatars/admin_avatar.jpg" alt="Аватар" class="avatar">
                <h2 id="username"><?php echo htmlspecialchars($username)?></h2>
                <a id="logout" href="logout.php">Выйти</a>
            </div>
        </div>
        <div class="info-right">
            <div class="new-categories">
                <form method="post">
                    <input name="title" type="text" placeholder="Введите новую категорию">
                    <button name="create-categories" type="submit">Создать</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>