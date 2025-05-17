<?php
$page_title = 'Xóa Tool';
require_once 'config.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
$message = "";

if ($id) {
    $sql_check_keys = "SELECT COUNT(`id`) AS count FROM `keys` WHERE `tool_id` = ?";
    $stmt_check_keys = $conn->prepare($sql_check_keys);
    $stmt_check_keys->bind_param("i", $id);
    $stmt_check_keys->execute();
    $result_check_keys = $stmt_check_keys->get_result();
    $row_check_keys = $result_check_keys->fetch_assoc();
    if ($row_check_keys['count'] > 0) {
        $message = "<div class='alert alert-warning'>Không thể xóa tool này vì vẫn còn key liên kết. Vui lòng xóa các key trước.</div>";
    } else {
        $sql_delete_tool = "DELETE FROM `tools` WHERE `id` = ?";
        $stmt_delete_tool = $conn->prepare($sql_delete_tool);
        $stmt_delete_tool->bind_param("i", $id);
        if ($stmt_delete_tool->execute()) {
            $message = "<div class='alert alert-success'>Tool đã được xóa thành công.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Lỗi khi xóa tool: " . $conn->error . "</div>";
        }
        $stmt_delete_tool->close();
    }
    $stmt_check_keys->close();
} else {
    $message = "<div class='alert alert-danger'>Không tìm thấy ID tool.</div>";
}

ob_start();
?>
<h1>Xóa Tool</h1>
<?php echo $message; ?>
<p><a href="index.php" class="btn btn-secondary btn-sm">Quay lại Dashboard</a></p>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>