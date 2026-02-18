<?php
    // Запускаем сессию
    session_start();
    require_once("config.php");

    // Проверяем, авторизован ли пользователь
    $isLoggedIn = isset($_SESSION['username']);
    $username = $isLoggedIn ? $_SESSION['username'] : '';

    // Получаем товары этого магазина по ID
    $query=("SELECT * FROM products");
    $stmt = $db->prepare($query);
    $stmt->execute();
    $products_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <title>Lime</title>
</head>
<body>
    <header>
        <div id="logo">
        <a href="index.php">
            <p>Lime</p>
        </a>
        </div>
        <div class="search">
            <input type="search" placeholder="Найти товар">
        </div>
        <div class="menu">
            <div class="select">
                <select name="categories" id="cat" >
                    <option hidden>Категория</option>
                    <option value="Одежда и обувь">Одежда и обувь</option>
                    <option value="Электроника">Электроника</option>
                    <option value="Товары для дома">Товары для дома</option>
                </select>
            </div>
            <div class="link">
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php">Профиль (<?php echo htmlspecialchars($username); ?>)</a>
                <?php else: ?>
                    <a href="login.php">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <!-- <div class="event">
        <div class="event-left">
            <h1>Скидки на товары до 90%!</h1>
            <p>Успейте до 18 марта 2026 года!</p>
        </div>
        <div class="event-right">
            <img src="img/events.jpg" alt="картинка с акцией">
        </div>
    </div> -->
    <div class="products">
        <?php 
        if ($products_result->num_rows > 0) {
            while ($product = $products_result->fetch_assoc()) {
        ?>
        <div class="card">
            <a href="#"> <!--ссылка на товар-->
                <div id="top-content">
                    <img src="uploads/products/<?php echo htmlspecialchars($product['photo']) ?>" alt="Фото товара">
                </div>
                <div id="bottom-content">
                    <h4 id="sale"><?php echo htmlspecialchars($product['price']) ?></h4>
                    <h5 id="name"><?php echo htmlspecialchars($product['title']) ?></h5>
                    <h5 id="rate">Рейтинг</h5>
                </div>
            </a>    
            <button id="basket">Добавить в корзину</button> <!--кнопка добавления товара в корзину-->
        </div>
        <?php 
        }
            } else {
            echo "<h3 id='empty'>В этом магазине пока нет товаров</h3>";
        }
        $stmt->close();
        ?>
    </div>
</body>
</html>