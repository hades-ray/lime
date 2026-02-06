<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$db = mysqli_connect("localhost", "root", "", "lime");

$username = $_SESSION['username'];
$target_dir = "uploads/avatars/"; // папка для аватаров
$default_avatar = "default_avatar.jpg";

// Создаем папку, если ее нет
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    // Проверяем, является ли файл изображением
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        die("Файл не является изображением.");
    }
    
    // Генерируем уникальное имя файла
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        die("Допустимые форматы: JPG, PNG, GIF.");
    }
    
    $new_file_name = $username . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;
    
    // Пытаемся загрузить файл
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Обновляем запись в БД
        $stmt = $db->prepare("UPDATE users SET avatar = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_file_name, $username);
        $stmt->execute();
        $stmt->close();
        
        // Перенаправляем обратно в профиль
        header("Location: profile.php");
        exit();
    } else {
        echo "Ошибка при загрузке файла.";
    }
}
?>