// assets/js/script.js

// Đây là nơi bạn viết các đoạn mã JavaScript tùy chỉnh cho trang web của mình.

// Ví dụ: Thêm hiệu ứng đơn giản khi di chuột qua sản phẩm
document.addEventListener('DOMContentLoaded', function() {
    const productItems = document.querySelectorAll('.product-item');

    productItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'box-shadow 0.3s ease, transform 0.3s ease';
        });

        item.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
            this.style.transform = 'translateY(0)';
            this.style.transition = 'box-shadow 0.3s ease, transform 0.3s ease';
        });
    });

    // Thêm các xử lý JavaScript khác tại đây, ví dụ:
    // - Xử lý sự kiện cho nút "Thêm vào giỏ hàng"
    // - Hiển thị/ẩn các phần tử trên trang
    // - Gọi API để tương tác với server (nếu có)
});