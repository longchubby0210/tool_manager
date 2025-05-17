<?php

// Đây là nơi bạn định nghĩa các hàm tiện ích dùng chung cho toàn bộ ứng dụng

// Ví dụ: Hàm để hiển thị thông báo
function displayAlert($type, $message) {
    echo '<div class="alert alert-' . htmlspecialchars($type) . ' alert-dismissible fade show" role="alert">';
    echo htmlspecialchars($message);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

// Ví dụ: Hàm để format tiền tệ
function formatCurrency($amount, $currencySymbol = '₫') {
    return number_format($amount, 0, ',', '.') . ' ' . htmlspecialchars($currencySymbol);
}

// Ví dụ: Hàm để tạo URL thân thiện (slug)
function createSlug($string) {
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $slug = strtolower($slug);
    return $slug;
}

// Thêm các hàm tiện ích khác của bạn ở đây
?>