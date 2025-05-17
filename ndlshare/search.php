<?php
$pageTitle = 'Kết quả tìm kiếm';
include_once 'includes/header.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$searchResults = [];

if (!empty($keyword)) {
    // Tìm kiếm sản phẩm dựa trên từ khóa (ví dụ: tìm kiếm trong tên và mô tả)
    $sqlSearch = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
    $searchTerm = '%' . $keyword . '%';
    $resultSearch = executeQuery($conn, $sqlSearch, [$searchTerm, $searchTerm], 'ss');
    $searchResults = fetchAll($resultSearch);
}
?>

<div class="container">
    <h1>Kết quả tìm kiếm</h1>

    <form class="mb-3" action="search.php" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
            <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    <?php if (!empty($keyword)): ?>
        <?php if (!empty($searchResults)): ?>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($searchResults as $product): ?>
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
            <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($keyword); ?>".</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Vui lòng nhập từ khóa để tìm kiếm sản phẩm.</p>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>