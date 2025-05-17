<?php
$page_title = 'Thêm Key';
require_once 'config.php';

$tool_id = isset($_GET['tool_id']) && is_numeric($_GET['tool_id']) ? $_GET['tool_id'] : null;
$tool_name = "";
$message = "";

if ($tool_id) {
    $sql_tool_name = "SELECT `name` FROM `tools` WHERE `id` = ?";
    $stmt_tool_name = $conn->prepare($sql_tool_name);
    $stmt_tool_name->bind_param("i", $tool_id);
    $stmt_tool_name->execute();
    $result_tool_name = $stmt_tool_name->get_result();
    if ($result_tool_name->num_rows == 1) {
        $row_tool_name = $result_tool_name->fetch_assoc();
        $tool_name = $row_tool_name['name'];
    } else {
        $message = "<div class='alert alert-danger'>Không tìm thấy tool với ID này.</div>";
        $tool_id = null;
    }
    $stmt_tool_name->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $tool_id) {
    $key_value = $_POST["key_value"];
    if (!empty($key_value)) {
        $sql_check = "SELECT `id` FROM `keys` WHERE `tool_id` = ? AND `key_value` = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("is", $tool_id, $key_value);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $message = "<div class='alert alert-warning'>Key này đã tồn tại cho tool này.</div>";
        } else {
            $sql_insert = "INSERT INTO `keys` (`tool_id`, `key_value`) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("is", $tool_id, $key_value);
            if ($stmt_insert->execute()) {
                $message = "<div class='alert alert-success'>Key '$key_value' đã được thêm cho tool '$tool_name' thành công.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Lỗi khi thêm key: " . $conn->error . "</div>";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    } else {
        $message = "<div class='alert alert-warning'>Vui lòng nhập giá trị key.</div>";
    }
}

ob_start();
?>
<h1>Thêm Key cho Tool: <?php echo $tool_name; ?></h1>
<?php echo $message; ?>
<?php if ($tool_id): ?>
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?tool_id=" . $tool_id; ?>">
                <div class="form-group">
                    <label for="key_value">Giá trị Key:</label>
                    <input type="text" class="form-control" name="key_value" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm Key</button>
                <a href="list_keys.php?tool_id=<?php echo $tool_id; ?>" class="btn btn-secondary">Xem Danh Sách Key</a>
                <a href="index.php" class="btn btn-secondary">Quay lại Dashboard</a>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger">Không tìm thấy tool với ID này.</div>
    <a href="index.php" class="btn btn-secondary">Quay lại Dashboard</a>
<?php endif; ?>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>