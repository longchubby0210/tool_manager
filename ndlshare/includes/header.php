<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/functions.php';
include_once 'includes/auth.php';
include_once 'includes/cart_functions.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'NDL SHARE ALL'; ?></title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="margin:0;padding:0;width:100vw;max-width:100vw;box-sizing:border-box;">
<div class="dashboard-wrapper">