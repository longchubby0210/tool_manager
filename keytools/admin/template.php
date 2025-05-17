<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login.php");
    exit();
}

$page_title = isset($page_title) ? $page_title : 'Quản Trị';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin_style.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">


</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="index.php" class="sidebar-logo">Purple</a>
            </div>
            <div class="user-panel">
                <div class="user-avatar">
                    <img src="../images/default-user.png" alt="User Avatar"style="width: 40px; height: 40px;">
                </div>
                <div class="user-info">
                    <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></span>
                    <small>Project Manager</small>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="add_tool.php"><i class="fas fa-plus-circle"></i> Thêm Tool</a></li>
                <li><a href="index.php"><i class="fas fa-list"></i> Danh Sách Tool</a></li>
                </ul>
        </div>
        <div class="main-content">
            <header>
                <div class="search-bar">
                    <input type="text" placeholder="Search projects...">
                </div>
                <div class="top-navigation">
                    <ul>
                        <li><a href="#"><i class="far fa-envelope"></i></a></li>
                        <li><a href="#"><i class="far fa-bell"></i></a></li>
                        <li class="user-dropdown">
                            <a href="#" class="user-avatar"><img src="../images/default-user.png" alt="User Avatar"style="width: 40px; height: 40px;"></a>
                            </li>
                        <li>
                            <div class="theme-toggle">
                                <button id="theme-toggle-btn">Chế độ Sáng</button>
                            </div>
                        </li>
                        <li><a href="#"><i class="fas fa-bars"></i></a></li> </ul>
                </div>
            </header>
            <main>
                <?php if (isset($content)) { echo $content; } ?>
            </main>
        </div>
    </div>
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        const body = document.body;
        let isDarkMode = localStorage.getItem('darkMode') === 'enabled';

        if (isDarkMode) {
            body.classList.add('dark-mode');
            themeToggleBtn.textContent = 'Chế độ Tối';
        }

        themeToggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            isDarkMode = !isDarkMode;
            localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
            themeToggleBtn.textContent = isDarkMode ? 'Chế độ Tối' : 'Chế độ Sáng';
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"
        integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w=="
        crossorigin="anonymous"></script>

    </body>
</html>