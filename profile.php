<?php
    session_start();
    $db=mysqli_connect("localhost","root","","lime");

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
                    <input type="file" name="avatar" accept="image/*" required>
                    <button type="submit">Загрузить аватар</button>
                </form>
            </div>
        </div>
        <div class="info-right">
            <h2 id="username">hadesray</h2>
            <h4 id="phone" style="opacity: 60%;">+79538458598</h4>
            <a id="logout" href="logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>