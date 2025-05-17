<?php
require_once 'admin/config.php';

$sql = "SELECT `id`, `name`, `is_active` FROM `tools` ORDER BY `name`";
$result = $conn->query($sql);
$tools = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tools[] = $row;
    }
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tool_id = $_POST["tool_id"];
    $user_key = $_POST["user_key"];

    $sql_check = "SELECT k.`id` FROM `keys` k
                  INNER JOIN `tools` t ON k.`tool_id` = t.`id`
                  WHERE k.`key_value` = ? AND k.`tool_id` = ? AND t.`is_active` = 1";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("si", $user_key, $tool_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $message = "<div class='alert alert-success'>Key hợp lệ. Tool đã được kích hoạt.</div>";
        // Ở đây bạn có thể thực hiện hành động cho phép người dùng sử dụng tool
    } else {
        $message = "<div class='alert alert-danger'>Key không hợp lệ hoặc tool chưa được kích hoạt.</div>";
    }

    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tool</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Kiểm Tra Key Tool</h1>
        <?php echo $message; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="tool_id">Chọn Tool:</label>
                <select class="form-control" name="tool_id" required>
                    <?php foreach ($tools as $tool): ?>
                        <option value="<?php echo $tool['id']; ?>"><?php echo $tool['name']; ?> (<?php echo $tool['is_active'] ? 'Đã kích hoạt' : 'Chưa kích hoạt'; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="user_key">Nhập Key:</label>
                <input type="text" class="form-control" name="user_key" required>
            </div>
            <button type="submit" class="btn btn-primary">Kiểm Tra</button>
        </form>

        <h2>Danh Sách Tool</h2>
        <ul class="tool-list">
            <?php foreach ($tools as $tool): ?>
                <li class="tool-item">
                    <span class="tool-name"><?php echo $tool['name']; ?></span>
                    <span class="tool-status"><?php echo $tool['is_active'] ? '<span style="color: green;">Đã kích hoạt</span>' : '<span style="color: red;">Chưa kích hoạt</span>'; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="admin-link">
            <a href="login.php">Đăng nhập quản trị</a>
        </div>
    </div>
</body>
</html>