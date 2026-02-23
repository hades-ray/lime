<?php
    // Запускаем сессию
    session_start();
    require_once("config.php");
    
    // Проверяем, авторизован ли пользователь
    $isLoggedIn = isset($_SESSION['username']) && isset($_SESSION['role']);
    $role = $isLoggedIn ? $_SESSION['role'] : '';
    $username = $isLoggedIn ? $_SESSION['username'] : '';
    
    // Получаем выбранную категорию из GET
    $selected_category = isset($_GET['category']) ? $_GET['category'] : '';
    
    // Получаем все категории из таблицы categories
    $cat_query = "SELECT * FROM categories";
    $stmt = $db->prepare($cat_query);
    $stmt->execute();
    $categories_result = $stmt->get_result();
    
    // Получаем товары с фильтрацией по названию категории
    if (!empty($selected_category) && $selected_category != 'all') {
        // Фильтруем по текстовому полю category в таблице products
        $query = "SELECT * FROM products WHERE type = ? ORDER BY id DESC";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $selected_category); // "s" для строки
    } else {
        $query = "SELECT * FROM products ORDER BY id DESC";
        $stmt = $db->prepare($query);
    }
    
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
                <!-- Форма фильтрации -->
                <form method="get" id="filter-form">
                    <select id="cat" name="category" onchange="document.getElementById('filter-form').submit();">
                        <option hidden <?php echo (empty($selected_category) || $selected_category == 'all') ? 'selected' : ''; ?>>Категория</option>
                        <option value="all" <?php echo ($selected_category == 'all') ? 'selected' : ''; ?>>Все категории</option>
                        <?php 
                        if ($categories_result->num_rows > 0) {
                            while ($categories = $categories_result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo htmlspecialchars($categories['title']) ?>" 
                                <?php echo ($selected_category == $categories['title']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categories['title']) ?>
                            </option>
                        <?php 
                            }
                        } else {
                            echo "<option>Пусто</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="link">
            <?php if ($isLoggedIn && $role == 'user'): ?>
                <a href="profile.php">Профиль (<?php echo htmlspecialchars($username); ?>)</a>
            <?php elseif ($isLoggedIn && $role == 'admin'): ?>
                <a href="admin-panel.php">Панель администратора</a>
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
            <?php if ($isLoggedIn && $role == 'admin'): ?>
                <button id="delete" type="submit">Удалить товар</button>
            <?php else: ?>
                <button id="basket">Добавить в корзину</button><!--кнопка добавления товара в корзину-->
            <?php endif; ?>
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