<?php
$page_title = 'Xóa Key';
require_once 'config.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
$tool_id = isset($_GET['tool_id']) && is_numeric($_GET['tool_id']) ? $_GET['tool_id'] : null;
$message = "";

if ($id) {
    $sql_delete = "DELETE FROM `keys` WHERE `id` = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    if ($stmt_delete->execute()) {
        $message = "<div class='alert alert-success'>Key đã được xóa thành công.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Lỗi khi xóa key: " . $conn->error . "</div>";
    }
    $stmt_delete->close();
} else {
    $message = "<div class='alert alert-danger'>Không tìm thấy ID key.</div>";
}

ob_start();
?>
<h1><?php echo ($page_title ?? 'Xóa'); ?></h1>
<?php echo $message; ?>
<p>
    <?php if (isset($_GET['tool_id'])): ?>
        <a href="list_keys.php?tool_id=<?php echo $_GET['tool_id']; ?>" class="btn btn-secondary">Quay lại Danh Sách Key</a>
    <?php else: ?>
        <a href="index.php" class="btn btn-secondary">Quay lại Dashboard</a>
    <?php endif; ?>
</p>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>