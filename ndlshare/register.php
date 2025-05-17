<?php
$pageTitle = 'Đăng ký';
include_once 'includes/header.php';
requireGuest(); // Chỉ cho phép khách truy cập trang này

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_POST['email']; // Thêm email

    if ($password !== $confirmPassword) {
        $error = 'Mật khẩu không khớp.';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } else {
        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        $sqlCheck = "SELECT * FROM users WHERE username = ?";
        $resultCheck = executeQuery($conn, $sqlCheck, [$username], 's');
        if (fetchRow($resultCheck)) {
            $error = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
        } else {
            // Mã hóa mật khẩu
            $hashedPassword = hashPassword($password);

            // Thêm người dùng mới vào database (bao gồm email)
            $sqlInsert = "INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, NOW())";
            $insertResult = executeQuery($conn, $sqlInsert, [$username, $hashedPassword, $email], 'sss');

            if ($insertResult) {
                displayAlert('success', 'Đăng ký thành công. Bạn có thể <a href="login.php">đăng nhập</a> ngay bây giờ.');
            } else {
                $error = 'Đã có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.';
            }
        }
    }
}
?>

<div class="container">
    <h1>Đăng ký tài khoản</h1>
    <?php if ($error): ?>
        <?php displayAlert('danger', $error); ?>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
        <p class="mt-2">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>