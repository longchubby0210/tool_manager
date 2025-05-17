<?php
$pageTitle = 'Thanh toán';
include_once 'includes/header.php';
requireLogin(); // Yêu cầu người dùng đăng nhập để thanh toán

$cartItems = getCartItems($conn);
$totalPrice = getCartTotal($conn);

if (empty($cartItems)) {
    header("Location: cart.php"); // Chuyển hướng nếu giỏ hàng trống
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin giao hàng và thanh toán từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $paymentMethod = $_POST['payment_method'];
    $userId = getLoggedInUserId();

    // Thực hiện validation dữ liệu (bạn nên thêm validation chi tiết hơn)
    if (empty($name) || empty($email) || empty($address) || empty($phone)) {
        $error = 'Vui lòng điền đầy đủ thông tin giao hàng.';
    } else {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        $conn->begin_transaction();

        try {
            // 1. Tạo đơn hàng mới
            $sqlOrder = "INSERT INTO orders (user_id, total_amount, order_date, payment_method, shipping_address, customer_name, customer_email, customer_phone, order_status) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, 'pending')";
            $stmtOrder = $conn->prepare($sqlOrder);
            $stmtOrder->bind_param('idsissss', $userId, $totalPrice, $paymentMethod, $address, $name, $email, $phone);
            $stmtOrder->execute();
            $orderId = $conn->insert_id;
            $stmtOrder->close();

            // 2. Thêm chi tiết đơn hàng
            $sqlOrderItem = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmtOrderItem = $conn->prepare($sqlOrderItem);

            foreach ($cartItems as $item) {
                $productId = $item['product']['id'];
                $quantity = $item['quantity'];
                $price = $item['product']['price'];
                $stmtOrderItem->bind_param('iiid', $orderId, $productId, $quantity, $price);
                $stmtOrderItem->execute();
                }
            $stmtOrderItem->close();

            // 3. Xóa giỏ hàng sau khi đặt hàng thành công
            clearCart();

            // Commit transaction
            $conn->commit();

            // Chuyển hướng đến trang thông báo đặt hàng thành công
            header("Location: order_success.php?order_id=" . $orderId);
            exit();

        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $conn->rollback();
            $error = 'Đã có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại sau.';
            // Bạn có thể ghi log lỗi ở đây để debug
        }
    }
}
?>

<div class="container">
    <h1>Thanh toán</h1>
    <?php if ($error): ?>
        <?php displayAlert('danger', $error); ?>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>
        <div class="row">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Thông tin giao hàng</h4>
                <form class="needs-validation" method="POST">
                    <div class="mb-3">
                        <label for="name">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($currentUser['username'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">Phương thức thanh toán</h4>

                    <div class="my-3">
                        <div class="form-check">
                            <input id="cod" name="payment_method" type="radio" class="form-check-input" value="cod" checked required>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check">
                            <input id="banktransfer" name="payment_method" type="radio" class="form-check-input" value="banktransfer" disabled>
                            <label class="form-check-label" for="banktransfer">Chuyển khoản ngân hàng (chưa hỗ trợ)</label>
                        </div>
                        </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Đặt hàng</button>
                </form>
            </div>
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Giỏ hàng của bạn</span>
                    <span class="badge bg-secondary rounded-pill"><?php echo count($cartItems); ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($item['product']['name']); ?></h6>
                                <small class="text-muted">Số lượng: <?php echo htmlspecialchars($item['quantity']); ?></small>
                            </div>
                            <span class="text-muted"><?php echo formatCurrency($item['product']['price'] * $item['quantity']); ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tổng cộng (VNĐ)</span>
                        <strong><?php echo formatCurrency($totalPrice); ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    <?php else: ?>
        <p>Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.</p>
        <p><a href="index.php">Tiếp tục mua sắm</a></p>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>