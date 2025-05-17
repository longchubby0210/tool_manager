<?php
include_once 'includes/header.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $result = executeQuery($conn, $sql, [$productId], 'i');
    $product = fetchRow($result);

    if ($product) {
        $pageTitle = htmlspecialchars($product['name']);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="lead"><?php echo formatCurrency($product['price']); ?></p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                        </div>
                        <button type="submit" class="btn btn-success" name="add_to_cart">Thêm vào giỏ hàng</button>
                        </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        // Sản phẩm không tồn tại
        ?>
        <div class="container">
            <p class="alert alert-danger">Sản phẩm không tồn tại.</p>
        </div>
        <?php
    }
} else {
    // ID sản phẩm không hợp lệ
    ?>
    <div class="container">
        <p class="alert alert-danger">ID sản phẩm không hợp lệ.</p>
    </div>
    <?php
}

include_once 'includes/footer.php';
?>