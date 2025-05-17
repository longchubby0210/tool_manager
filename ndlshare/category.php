<?php
include_once 'includes/header.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = $_GET['id'];
    // Lấy thông tin danh mục
    $sqlCategory = "SELECT * FROM categories WHERE id = ?";
    $resultCategory = executeQuery($conn, $sqlCategory, [$categoryId], 'i');
    $category = fetchRow($resultCategory);

    if ($category) {
        $pageTitle = htmlspecialchars($category['name']);
        // Lấy danh sách sản phẩm thuộc danh mục này
        $sqlProducts = "SELECT * FROM products WHERE category_id = ?";
        $resultProducts = executeQuery($conn, $sqlProducts, [$categoryId], 'i');
        $productsInCategory = fetchAll($resultProducts);
        ?>
        <div class="container">
            <h1><?php echo htmlspecialchars($category['name']); ?></h1>
            <?php if (!empty($productsInCategory)): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php foreach ($productsInCategory as $product): ?>
                        <div class="col">
                            <div class="card">
                                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text"><?php echo formatCurrency($product['price']); ?></p>
                                    <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
        <?php
    } else {
        // Danh mục không tồn tại
        ?>
        <div class="container">
            <p class="alert alert-danger">Danh mục không tồn tại.</p>
        </div>
        <?php
    }
} else {
    // ID danh mục không hợp lệ
    ?>
    <div class="container">
        <p class="alert alert-danger">ID danh mục không hợp lệ.</p>
    </div>
    <?php
}

include_once 'includes/footer.php';
?>