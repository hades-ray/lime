<?php
session_start();

// Функция проверки авторизации
function isLoggedIn() {
    return isset($_SESSION['id']);
}

// Пример функции авторизации (вызовите её при успешном входе)
function login($user_id, $user_name) {
    $_SESSION['id'] = $user_id;
    $_SESSION['username'] = $user_name;
}

// Функция выхода
function logout() {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>