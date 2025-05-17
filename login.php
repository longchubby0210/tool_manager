<?php
session_start();
require_once 'admin/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập tên đăng nhập và mật khẩu.";
    } else {
        $sql = "SELECT `id`, `username`, `password`, `is_admin` FROM `users` WHERE `username` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($password == $row["password"]) { // So sánh trực tiếp (như bạn yêu cầu)
                if ($row["is_admin"]) {
                    $_SESSION['user_id'] = $row["id"];
                    $_SESSION['username'] = $row["username"];
                    $_SESSION['is_admin'] = true;
                    header("Location: admin/");
                    exit();
                } else {
                    $error = "Tài khoản này không có quyền quản trị.";
                }
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Đăng Nhập Quản Trị</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
        <p><a href="index.php">Về trang chính</a></p>
    </div>
</body>
</html>