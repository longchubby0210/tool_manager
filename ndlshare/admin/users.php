<?php
session_start();
include '../includes/auth.php';
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}
include '../includes/header.php';

// Giả sử bạn có hàm getAllUsers() để lấy tất cả người dùng từ database
$users = getAllUsers();
?>

<main class="admin-page">
    <div class="container">
        <h1>Quản lý người dùng</h1>
        <div class="mb-3">
            <a href="add_user.php" class="btn btn-success">Thêm người dùng mới</a>
        </div>
        <?php if (!empty($users)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Quyền hạn</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo ($user['is_admin'] ? 'Admin' : 'Người dùng'); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info">Chưa có người dùng nào.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>