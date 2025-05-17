<?php
// File: includes/db.php

// Đảm bảo đường dẫn tới config.php đúng
require_once __DIR__ . '/../config.php';

// Kết nối DB
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}
$conn->set_charset(DB_CHARSET);

// Hàm tiện ích
function executeQuery($conn, $sql, $params = [], $types = "") {
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;
    if (!empty($params)) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function fetchRow($result) {
    return $result ? $result->fetch_assoc() : null;
}

function fetchAll($result) {
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
