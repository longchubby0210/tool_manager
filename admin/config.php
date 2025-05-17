<?php
$servername = "localhost"; // Thay bằng tên server của bạn (thường là localhost)
$username = "root"; // Thay bằng username cơ sở dữ liệu của bạn
$password = ""; // Thay bằng mật khẩu cơ sở dữ liệu của bạn
$dbname = "tools";   // Thay bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); // Đặt encoding sang UTF-8 để hỗ trợ tiếng Việt

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
?>