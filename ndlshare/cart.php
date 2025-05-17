<?php
$pageTitle = 'Giỏ hàng';
include_once 'includes/header.php';
// Xử lý thêm vào giỏ hàng từ trang product.php
if (isset($_POST['add_to_cart']) && isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ? intval($_POST['quantity']) : 1;
    addToCart($productId, $quantity);
    displayAlert('success', 'Đã thêm sản phẩm vào giỏ hàng.');
}

// Xử lý cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $productId => $quantity) {
            if (is_numeric($productId) && is_numeric($quantity)) {
                updateCartItem($productId, intval($quantity));
            }
        }
        displayAlert('success', 'Giỏ hàng đã được cập nhật.');
    }
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    removeFromCart($_GET['remove']);
    displayAlert('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
}

$cartItems = getCartItems($conn);
$totalPrice = getCartTotal($conn);
?>

<div class="container">
    <h1>Giỏ hàng của bạn</h1>
    <?php if (empty($cartItems)): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
        <p><a href="index.php">Tiếp tục mua sắm</a></p>
    <?php else: ?>
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <img src="uploads/<?php echo htmlspecialchars($item['product']['image']); ?>" alt="<?php echo htmlspecialchars($item['product']['name']); ?>" width="50">
                                <?php echo htmlspecialchars($item['product']['name']); ?>
                            </td>
                            <td><?php echo formatCurrency($item['product']['price']); ?></td>
                            <td>
                                <input type="number" class="form-control" name="quantities[<?php echo htmlspecialchars($item['product']['id']); ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                            </td>
                            <td><?php echo formatCurrency($item['product']['price'] * $item['quantity']); ?></td>
                            <td><a href="cart.php?remove=<?php echo htmlspecialchars($item['product']['id']); ?>" class="btn btn-danger btn-sm">Xóa</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td><strong><?php echo formatCurrency($totalPrice); ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <button type="submit" class="btn btn-primary" name="update_cart">Cập nhật giỏ hàng</button>
                <a href="checkout.php" class="btn btn-success">Tiến hành thanh toán</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>