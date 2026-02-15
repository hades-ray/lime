<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    
    $title = $_POST['product-title'];
    $description = $_POST['product-description'];
    $category = $_POST['product-category'];
    $price = $_POST['product-price'];
    $username = $_SESSION['username'];
    
    // Получаем ID магазина по owner = текущий пользователь
    $magazine_query = "SELECT id FROM magazine WHERE owner = ?";
    $stmt_mag = $db->prepare($magazine_query);
    $stmt_mag->bind_param("s", $username);
    $stmt_mag->execute();
    $mag_result = $stmt_mag->get_result();
    
    if ($mag_result->num_rows === 0) {
        die("Ошибка: У вас нет магазина. Сначала создайте магазин.");
    }
    
    $magazine = $mag_result->fetch_assoc();
    $magazine_id = $magazine['id'];
    
    $file = $_FILES['product-photo'];
    $target_dir = "uploads/products/";
    
    // Создаем папку если нет
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Простое имя файла
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_file_name = time() . "_" . $magazine_id . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;
    
    // Загружаем файл
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        
        // Используем подготовленные выражения
        $sql = "INSERT INTO products (title, description, type, photo, price, magazine) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssdi", $title, $description, $category, $new_file_name, $price, $magazine_id);
        
        if ($stmt->execute()) {
            echo "Товар успешно добавлен!";
            header("Location: magazine.php");
            exit();
        } else {
            echo "Ошибка: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Ошибка загрузки файла";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/new_product.css">
    <title>Загрузить новый товар</title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
    </header>
    <div class="new-prod">
        <form method="post" enctype="multipart/form-data">
            <input class="input" name="product-title" type="text" placeholder="Введите название товара" required>
            <textarea class="input" name="product-description" placeholder="Напишите кратко о товаре" required></textarea>
            <select class="input" name="product-category" required>
                <option hidden>Выберите категорию товара</option>
                <option value="Одежда и обувь">Одежда и обувь</option>
                <option value="Электроника">Электроника</option>
                <option value="Товары для дома">Товары для дома</option>
            </select>

            <!-- Поле для загрузки фото с отображением имени файла -->
            <div class="file-upload-wrapper">
                <label for="product-photo" class="custom-file-upload">
                    Выберите фото товара
                </label>
                <input type="file" id="product-photo" name="product-photo" accept="image/jpeg,image/png,image/gif" required>
                <span id="file-name">Файл не выбран</span>
            </div>

            <input class="input" type="number" name="product-price" required placeholder="Укажите цену товара">
            <button name="create" type="submit">Загрузить товар</button>
        </form>
    </div>


    <script>
        document.getElementById('product-photo').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Файл не выбран';
            document.getElementById('file-name').textContent = 'Выбран файл ' + fileName;
        });
    </script>
</body>
</html>