<?php
$page_title = 'Dashboard Quản Trị';
ob_start();
?>
<div id="message-container"></div>
<div class="dashboard-cards">
    <div class="card">
        <div class="card-header">Weekly Sales</div>
        <div class="card-body">$15,0000</div>
        <div class="card-footer">Increased by 60%</div>
    </div>
    <div class="card">
        <div class="card-header">Weekly Orders</div>
        <div class="card-body">45,6334</div>
        <div class="card-footer">Decreased by 10%</div>
    </div>
    <div class="card">
        <div class="card-header">Visitors Online</div>
        <div class="card-body">95,5741</div>
        <div class="card-footer">Increased by 5%</div>
    </div>
</div>

<div class="chart-container">
    <h3>Visit And Sales Statistics</h3>
    <canvas id="visitSalesChart"></canvas>
</div>

<div class="data-table">
    <h3>Danh Sách Tool</h3>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Tool</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'config.php';
            $sql = "SELECT `id`, `name`, `is_active` FROM `tools` ORDER BY `name`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . ($row['is_active'] ? '<span style="color: green;">Đã kích hoạt</span>' : '<span style="color: red;">Chưa kích hoạt</span>') . "</td>";
                    echo "<td>";
                    echo '<a href="edit_tool.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Sửa</a> ';
                    echo '<a href="delete_tool.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa tool này?\')">Xóa</a> ';
                    echo '<a href="add_key.php?tool_id=' . $row['id'] . '" class="btn btn-info btn-sm">Thêm Key</a> ';
                    echo '<a href="list_keys.php?tool_id=' . $row['id'] . '" class="btn btn-secondary btn-sm">Xem Keys</a> ';
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="4">Không có tool nào.</td></tr>';
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
require_once 'template.php';
?>