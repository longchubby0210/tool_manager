<?php
$page_title = 'Danh Sách Key';
require_once 'config.php';

// Lấy tool_id từ GET request và đảm bảo nó là một số nguyên dương
$tool_id = isset($_GET['tool_id']) && is_numeric($_GET['tool_id']) && $_GET['tool_id'] > 0 ? (int)$_GET['tool_id'] : null;
$tool_name = "";
$error = "";
$keys = [];

// Ghi log để kiểm tra giá trị của $tool_id
error_log("list_keys.php: tool_id = " . $tool_id);

if ($tool_id) {
    // Lấy tên tool để hiển thị
    $sql_tool_name = "SELECT `name` FROM `tools` WHERE `id` = ?";
    $stmt_tool_name = $conn->prepare($sql_tool_name);
    $stmt_tool_name->bind_param("i", $tool_id);
    $stmt_tool_name->execute();
    $result_tool_name = $stmt_tool_name->get_result();

    if ($result_tool_name->num_rows == 1) {
        $row_tool_name = $result_tool_name->fetch_assoc();
        $tool_name = $row_tool_name['name'];

        // Truy vấn để lấy danh sách key cho tool cụ thể
        $sql = "SELECT `id`, `key_value` FROM `keys` WHERE `tool_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tool_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ghi log số lượng key tìm thấy
        error_log("list_keys.php: Number of keys found for tool ID " . $tool_id . " = " . $result->num_rows);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $keys[] = $row;
            }
        }

        $stmt->close();
    } else {
        $error = "Không tìm thấy tool với ID này.";
        error_log("list_keys.php: Error - Tool not found with ID: " . $tool_id);
    }
    $stmt_tool_name->close();
} else {
    $error = "Không có ID tool được cung cấp.";
    error_log("list_keys.php: Error - No valid tool ID provided.");
}

ob_start();
?>
<h1>Danh Sách Key cho Tool: <?php echo $tool_name; ?></h1>
<div id="message-container"></div>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php else: ?>
    <?php if (!empty($keys)): ?>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Giá trị Key</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keys as $key): ?>
                        <tr>
                            <td><?php echo $key['id']; ?></td>
                            <td><?php echo htmlspecialchars($key['key_value']); ?></td>
                            <td>
                                <a href="delete_key.php?id=<?php echo $key['id']; ?>&tool_id=<?php echo $tool_id; ?>"
   class="btn btn-danger btn-sm action-button"
   data-action="delete-key"
   data-item-id="<?php echo $key['id']; ?>"
   data-item-name="<?php echo htmlspecialchars($key['key_value']); ?>">Xóa</a>
<tr data-row-id="<?php echo $key['id']; ?>">
    </tr>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Không có key nào được thêm cho tool này.</div>
    <?php endif; ?>
<?php endif; ?>
<div class="mt-3">
    <a href="add_key.php?tool_id=<?php echo $tool_id; ?>" class="btn btn-success btn-sm">Thêm Key mới</a>
    <a href="index.php" class="btn btn-secondary btn-sm">Quay lại Dashboard</a>
</div>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>