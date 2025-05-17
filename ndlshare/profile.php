<?php
$pageTitle = 'Thông tin cá nhân';
include_once 'includes/header.php';
requireLogin(); // Yêu cầu đăng nhập để xem trang này

$userId = getLoggedInUserId();
$currentUser = getUserById($conn, $userId);

if (!$currentUser) {
    // Xử lý trường hợp không tìm thấy người dùng (có thể do lỗi session)
    header("Location: logout.php");
    exit();
}

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Bạn có thể thêm các trường khác để cập nhật (ví dụ: địa chỉ, số điện thoại)

    // Thực hiện validation
    if (empty($name) || empty($email)) {
        $errorMessage = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        // Cập nhật thông tin người dùng trong database
        $sqlUpdate = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $updateResult = executeQuery($conn, $sqlUpdate, [$name, $email, $userId], 'ssi');

        if ($updateResult) {
            $successMessage = 'Thông tin cá nhân đã được cập nhật thành công.';
            // Cập nhật lại thông tin $currentUser để hiển thị thông tin mới
            $currentUser = getUserById($conn, $userId);
        } else {
            $errorMessage = 'Đã có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại sau.';
        }
    }
}
?>

<div class="container">
    <h1>Thông tin cá nhân</h1>

    <?php if ($successMessage): ?>
        <?php displayAlert('success', $successMessage); ?>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <?php displayAlert('danger', $errorMessage); ?>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
    </form>

    <h4 class="mt-4">Đổi mật khẩu</h4>
    <p><a href="change_password.php">Đổi mật khẩu</a></p>
</div>

<?php include_once 'includes/footer.php'; ?>