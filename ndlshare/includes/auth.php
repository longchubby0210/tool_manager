<?php

// Hàm kiểm tra xem người dùng đã đăng nhập hay chưa
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Hàm lấy ID người dùng đã đăng nhập
function getLoggedInUserId() {
    return isLoggedIn() ? $_SESSION['user_id'] : null;
}

// Hàm lấy tên người dùng đã đăng nhập
function getCurrentUsername() {
    return isLoggedIn() && isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

// Hàm chuyển hướng nếu người dùng chưa đăng nhập
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Hàm chuyển hướng nếu người dùng đã đăng nhập (ví dụ: không cho phép truy cập trang đăng ký/đăng nhập khi đã đăng nhập)
function requireGuest() {
    if (isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

// Hàm lấy thông tin người dùng từ ID
function getUserById($conn, $userId) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $result = executeQuery($conn, $sql, [$userId], 'i');
    return fetchRow($result);
}

// Hàm kiểm tra thông tin đăng nhập
function verifyUser($conn, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $result = executeQuery($conn, $sql, [$username], 's');
    $user = fetchRow($result);

    if ($user && password_verify($password, $user['password'])) {
        return $user['id']; // Trả về ID người dùng nếu đăng nhập thành công
    }
    return false; // Trả về false nếu đăng nhập thất bại
}

// Hàm mã hóa mật khẩu
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

?>