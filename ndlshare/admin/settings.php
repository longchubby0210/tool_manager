<?php
session_start();
include '../includes/auth.php';
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}
include '../includes/header.php';

// Giả sử bạn có hàm getWebsiteSettings() để lấy các cài đặt từ database
$settings = getWebsiteSettings();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý việc cập nhật cài đặt (cần viết logic backend)
    $websiteName = $_POST['websiteName'];
    $currency = $_POST['currency'];
    // ... các cài đặt khác

    // Giả sử có hàm updateWebsiteSettings($websiteName, $currency, ...)
    if (updateWebsiteSettings($websiteName, $currency)) {
        $_SESSION['message'] = 'Cài đặt đã được cập nhật thành công.';
        $_SESSION['message_type'] = 'success';
        header('Location: settings.php');
        exit();
    } else {
        $_SESSION['message'] = 'Đã có lỗi xảy ra khi cập nhật cài đặt.';
        $_SESSION['message_type'] = 'danger';
    }
}
?>

<main class="admin-page">
    <div class="container">
        <h1>Cài đặt chung</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="websiteName" class="form-label">Tên trang web</label>
                <input type="text" class="form-control" id="websiteName" name="websiteName" value="<?php echo $settings['website_name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Đơn vị tiền tệ</label>
                <input type="text" class="form-control" id="currency" name="currency" value="<?php echo $settings['currency'] ?? 'VND'; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>