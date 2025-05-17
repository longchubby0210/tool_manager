<?php
session_start();
include '../includes/auth.php';
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}
include '../includes/header.php';

// Giả sử bạn có hàm getAllCategories() để lấy tất cả danh mục từ database
$categories = getAllCategories();
?>

<main class="admin-page">
    <div class="container">
        <h1>Quản lý danh mục</h1>
        <div class="mb-3">
            <a href="add_category.php" class="btn btn-success">Thêm danh mục mới</a>
        </div>
        <?php if (!empty($categories)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo $category['name']; ?></td>
                            <td><?php echo $category['description']; ?></td>
                            <td>
                                <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info">Chưa có danh mục nào.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>