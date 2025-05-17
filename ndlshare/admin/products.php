<?php
session_start();
include '../includes/auth.php';
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}
include '../includes/header.php';

// Giả sử bạn có hàm getAllProducts() để lấy tất cả sản phẩm từ database
$products = getAllProducts();
?>

<main class="admin-page">
    <div class="container">
        <h1>Quản lý sản phẩm</h1>
        <div class="mb-3">
            <a href="add_product.php" class="btn btn-success">Thêm sản phẩm mới</a>
        </div>
        <?php if (!empty($products)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo formatCurrency($product['price']); ?></td>
                            <td><?php echo $product['category_name']; ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info">Chưa có sản phẩm nào.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>