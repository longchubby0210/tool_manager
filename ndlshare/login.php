<?php
$pageTitle = 'Đăng nhập';
include_once 'includes/header.php';
requireGuest(); // Chỉ cho phép khách truy cập trang này

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userId = verifyUser($conn, $username, $password);

    if ($userId) {
        $_SESSION['user_id'] = $userId;
        header("Location: index.php"); // Chuyển hướng đến trang chủ sau khi đăng nhập thành công
        exit();
    } else {
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
    }
}
?>

<div class="container">
    <h1>Đăng nhập</h1>
    <?php if ($error): ?>
        <?php displayAlert('danger', $error); ?>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
        <p class="mt-2">Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>