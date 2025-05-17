<?php
// File: config.php

define('DB_NAME', 'ndlshare');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// Giao diện và đường dẫn
define('ROOT_PATH', dirname(__FILE__));
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
define('BASE_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/project/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('UPLOADS_PATH', ROOT_PATH . '/uploads/');
define('UPLOADS_URL', BASE_URL . 'uploads/');
define('SECRET_KEY', 'MOT_CHUOI_BAO_MAT');
define('DEBUG_MODE', true);
define('SESSION_LIFETIME', 3600);
