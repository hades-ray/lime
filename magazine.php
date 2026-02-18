<?php
    session_start();
    require_once("config.php");

    $username = $_SESSION['username'];

    // Получаем данные магазина
    $stmt = $db->prepare("SELECT * FROM magazine WHERE owner = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Получаем ID магазина из результата
    $magazine_id = $user['id']; // ВАЖНО: получаем ID магазина
    $title = $user['title'];
    $description = $user['description'];

    // Получаем товары этого магазина по ID
    $stmt = $db->prepare("SELECT * FROM products WHERE magazine = ?");
    $stmt->bind_param("i", $magazine_id); // "i" для integer (ID)
    $stmt->execute();
    $products_result = $stmt->get_result();
    
    // Проверяем, есть ли результаты
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/magazine.css">
    <title>Магазин пользователя <?php echo $username=$_SESSION['username'];?></title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
        <div class="link">
            <a href="profile.php">Профиль (<?php echo htmlspecialchars($username); ?>)</a>
        </div>
    </header>
    <div class="content-magazine">
        <div class="top-info">
            <h2><?php echo htmlspecialchars($title) ?></h2>
            <p><?php echo htmlspecialchars($description) ?></p>
            <a href="new-product.php">Новый товар</a>
        </div>
        <div class="bottom-info">
            <?php 
                if ($products_result->num_rows > 0) {
                    while ($product = $products_result->fetch_assoc()) {
            ?>
            <div class="product">
                <div class="left-content">
                    <img src="uploads/products/<?php echo htmlspecialchars($product['photo']) ?>" alt="продукт">
                </div>
                <div class="right-content">
                    <h4><?php echo htmlspecialchars($product['title']) ?></h4>
                    <p><?php echo htmlspecialchars($product['description']) ?></p>
                    <h5><?php echo htmlspecialchars($product['price']) ?></h5>
                </div> 
            </div>
            <?php 
            }
                } else {
                echo "<h3 id='empty'>В этом магазине пока нет товаров</h3>";
            }
            $stmt->close();
            ?>
        </div>
    </div>
</body>
</html>