<?php
$page_title = 'Sửa Tool';
require_once 'config.php';

$message = "";
$tool = null;
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql_select = "SELECT `id`, `name`, `is_active` FROM `tools` WHERE `id` = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    if ($result_select->num_rows == 1) {
        $tool = $result_select->fetch_assoc();
    } else {
        $message = "<div class='alert alert-danger'>Không tìm thấy tool với ID này.</div>";
    }
    $stmt_select->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $tool) {
    $name = $_POST["name"];
    $is_active = isset($_POST["is_active"]) ? 1 : 0;
    $sql_update = "UPDATE `tools` SET `name` = ?, `is_active` = ? WHERE `id` = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sii", $name, $is_active, $id);
    if ($stmt_update->execute()) {
        $message = "<div class='alert alert-success'>Tool '$name' đã được cập nhật thành công.</div>";
        $sql_select_updated = "SELECT `id`, `name`, `is_active` FROM `tools` WHERE `id` = ?";
        $stmt_select_updated = $conn->prepare($sql_select_updated);
        $stmt_select_updated->bind_param("i", $id);
        $stmt_select_updated->execute();
        $result_select_updated = $stmt_select_updated->get_result();
        if ($result_select_updated->num_rows == 1) {
            $tool = $result_select_updated->fetch_assoc();
        }
        $stmt_select_updated->close();
    } else {
        $message = "<div class='alert alert-danger'>Lỗi khi cập nhật tool: " . $conn->error . "</div>";
    }
    $stmt_update->close();
}

ob_start();
?>
<h1>Sửa Tool</h1>
<?php echo $message; ?>
<?php if ($tool): ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $tool['id']; ?>">
        <div class="form-group">
            <label for="name">Tên Tool:</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($tool['name']); ?>" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="is_active" <?php echo $tool['is_active'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_active">Kích hoạt</label>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
        <p><a href="index.php" class="btn btn-secondary btn-sm">Quay lại Dashboard</a></p>
    </form>
<?php else: ?>
    <p><a href="index.php" class="btn btn-secondary btn-sm">Quay lại Dashboard</a></p>
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>