<?php
$mysqli = new mysqli("localhost", "root", "", "ndlshare");

if ($mysqli->connect_error) {
    die("Kết nối thất bại: " . $mysqli->connect_error);
}
echo "✅ Kết nối thành công!";
