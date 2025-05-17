<?php
session_start();
include '../includes/auth.php';
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}
include '../includes/header.php';

// Giả sử bạn có hàm getAllOrders() để lấy tất cả đơn hàng từ database
$orders = getAllOrders();
?>

<main class="admin-page">
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        <?php if (!empty($orders)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Mã người dùng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['user_id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo formatCurrency($order['total_amount']); ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="view_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-info">Xem chi tiết</a>
                                <a href="edit_order_status.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-warning">Sửa trạng thái</a>
                                <a href="delete_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info">Chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>