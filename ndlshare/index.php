<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pageTitle = 'Trang chủ';

require_once 'includes/db.php';
include_once 'includes/header.php';

// Lấy thông tin người dùng nếu đã đăng nhập
$loggedInUser = isLoggedIn() ? getUserById($conn, getLoggedInUserId()) : null;

// Lấy danh sách sản phẩm nổi bật
$sqlFeatured = "SELECT * FROM products WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 8";
$resultFeatured = executeQuery($conn, $sqlFeatured);
$featuredProducts = fetchAll($resultFeatured);

// Lấy danh sách sản phẩm mới nhất
$sqlLatest = "SELECT * FROM products ORDER BY created_at DESC LIMIT 8";
$resultLatest = executeQuery($conn, $sqlLatest);
$latestProducts = fetchAll($resultLatest);

// Lấy danh sách tất cả các danh mục
$sqlCategories = "SELECT * FROM categories";
$resultCategories = executeQuery($conn, $sqlCategories);
$categories = fetchAll($resultCategories);
?>
<!-- Không có comment hoặc khoảng trắng giữa các phần tử con của .dashboard-wrapper -->
<aside class="dashboard-sidebar">
    <div class="sidebar-logo">NDL SHARE</div>
    <ul class="sidebar-menu">
      <li><a href="#" class="active"><i class="fas fa-home"></i> Trang chủ</a></li>
      <li><a href="#"><i class="fas fa-gamepad"></i> Sản phẩm</a></li>
      <li><a href="#"><i class="fas fa-th-list"></i> Danh mục</a></li>
      <li><a href="#"><i class="fas fa-user"></i> Tài khoản</a></li>
      <li><a href="#"><i class="fas fa-cog"></i> Cài đặt</a></li>
    </ul>
    <!-- Xóa sidebar-user khỏi sidebar -->
  </aside>
<main class="dashboard-main">
    <div class="dashboard-header">
      <div class="dashboard-title">Trang chủ</div>
      <div class="dashboard-actions d-flex align-items-center" style="gap:1rem;">
        <?php if ($loggedInUser): ?>
        <div class="dashboard-user-header d-flex align-items-center" style="gap:0.5rem;">
          <img src="uploads/avatars/<?php echo htmlspecialchars($loggedInUser['avatar'] ?? ''); ?>" class="avatar" alt="User" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-color);">
          <span class="username" style="font-weight:600;"><?php echo htmlspecialchars($loggedInUser['username']); ?></span>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sản phẩm nổi bật -->
    <section class="dashboard-table-card">
      <div class="dashboard-table-title">Sản phẩm nổi bật</div>
      <div class="dashboard-cards">
        <?php foreach ($featuredProducts as $product): ?>
        <div class="dashboard-card">
          <?php if (!empty($product['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:100%;height:140px;object-fit:cover;border-radius:8px 8px 0 0;margin-bottom:0.5rem;">
          <?php endif; ?>
          <div class="card-title"><?php echo htmlspecialchars($product['name']); ?></div>
          <div class="card-value"><?php echo formatCurrency($product['price']); ?></div>
          <!-- <span class="card-icon"><i class="fas fa-star"></i></span> -->
          <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Sản phẩm mới nhất -->
    <section class="dashboard-table-card">
      <div class="dashboard-table-title">Sản phẩm mới nhất</div>
      <div class="dashboard-cards">
        <?php
        $count = 0;
        foreach ($latestProducts as $product):
            if ($count >= 4) break;
        ?>
        <div class="dashboard-card">
          <?php if (!empty($product['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:100%;height:140px;object-fit:cover;border-radius:8px 8px 0 0;margin-bottom:0.5rem;">
          <?php endif; ?>
          <div class="card-title"><?php echo htmlspecialchars($product['name']); ?></div>
          <div class="card-value"><?php echo formatCurrency($product['price']); ?></div>
          <!-- <span class="card-icon"><i class="fas fa-clock"></i></span> -->
          <a href="product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
        </div>
        <?php
            $count++;
        endforeach;
        ?>
      </div>
    </section>

    <!-- Danh mục sản phẩm -->
    <section class="dashboard-table-card">
      <div class="dashboard-table-title">Danh mục sản phẩm</div>
      <div class="d-grid grid-cols-auto grid-gap-3">
        <?php foreach ($categories as $category): ?>
        <div class="category-card">
          <div class="category-title">
            <a href="category.php?id=<?php echo htmlspecialchars($category['id']); ?>">
              <?php echo htmlspecialchars($category['name']); ?>
            </a>
          </div>
          <div class="category-description"><?php echo htmlspecialchars($category['description']); ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- About us -->
    <section class="about-us-section py-4 bg-light rounded-3" style="max-width:100%;margin:40px 0;">
      <div>
        <h2>Về chúng tôi</h2>
        <p class="lead">NDL SHARE là nơi chia sẻ game, phần mềm, tài nguyên chất lượng cho cộng đồng.</p>
      </div>
    </section>
  </main>
<?php include_once 'includes/footer.php'; ?>