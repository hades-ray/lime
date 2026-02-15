<?php
    session_start();
    require_once("config.php");

    $isLoggedIn = isset($_SESSION['username']);
    $username = $isLoggedIn ? $_SESSION['username'] : '';
    
    // Получаем данные пользователя, включая аватар
    $stmt = $db->prepare("SELECT phone, avatar FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    $avatar = !empty($user['avatar']) ? $user['avatar'] : 'default_avatar.jpg';
    $phone = $user['phone'] ?? '';

    // Проверяем, есть ли у пользователя магазин
    $query = "SELECT id FROM magazine WHERE owner = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$username]);
    $has_magazine = $stmt->fetch() ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/profile.css">
    <title>Профиль пользователя <?php echo htmlspecialchars($username); ?></title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <p>Lime</p>
            </a>
        </div>
    </header>
    <div class="user-info">
        <div class="info-left">
            <div class="avatar-container">
                <img src="uploads/avatars/<?php echo htmlspecialchars($avatar); ?>" alt="Аватар" class="avatar">
                <!-- Форма для загрузки нового аватара -->
                <form action="upload_avatar.php" method="POST" enctype="multipart/form-data">
                    <label for="upload-photo" id="custom-upload-file">
                        Загрузить фото
                        <input id="upload-photo" style="display:none;" type="file" name="avatar" accept="image/*" required placeholder="Выберите фото">
                    </label>
                    <button type="submit">Сохранить изменения</button>
                </form>
                <a id="logout" href="logout.php">Выйти</a>
            </div>
        </div>
        <div class="info-right">
            <h2 id="username"><?php echo htmlspecialchars($username)?></h2>
            <h4 id="phone" style="opacity: 60%;"><?php echo htmlspecialchars($phone)?></h4>
            <?php if ($has_magazine): ?>
                <!-- Если магазин есть - показываем ссылку на профиль магазина -->
                <a id="magazine" href="magazine.php">Мой магазин</a>
            <?php else: ?>
                <!-- Если магазина нет - показываем кнопку создания -->
                <a id="create" href="create-magazine.php">Создать свой магазин</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>