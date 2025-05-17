<?php
$page_title = 'Thêm Tool Mới';
require_once 'config.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    if (!empty($name)) {
        $sql = "INSERT INTO `tools` (`name`) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Tool '$name' đã được thêm thành công.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Lỗi khi thêm tool: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>Vui lòng nhập tên tool.</div>";
    }
}

ob_start();
?>
<h1>Thêm Tool Mới</h1>
<?php echo $message; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="name">Tên Tool:</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm Tool</button>
    <p><a href="index.php" class="btn btn-secondary btn-sm">Quay lại Dashboard</a></p>
</form>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>