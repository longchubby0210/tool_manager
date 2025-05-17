document.addEventListener('DOMContentLoaded', function() {
    const actionButtons = document.querySelectorAll('.action-button'); // Chọn tất cả các nút hành động

    actionButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a> hoặc <button>

            const action = this.dataset.action; // Lấy loại hành động (ví dụ: 'delete-key', 'delete-tool')
            const itemId = this.dataset.itemId;   // Lấy ID của item cần thao tác
            const itemName = this.dataset.itemName; // Lấy tên của item để hiển thị trong xác nhận
            const url = this.getAttribute('href'); // Lấy URL gửi yêu cầu AJAX

            if (!action || !itemId || !url) {
                console.error('Thiếu thuộc tính data-action, data-item-id hoặc href trên nút hành động.');
                return;
            }

            let confirmationMessage = `Bạn có chắc chắn muốn ${action.replace('delete-', 'xóa ')} ${itemName || 'mục này'} không?`;

            if (confirm(confirmationMessage)) {
                fetch(url, {
                    method: 'GET', // Hoặc 'POST' tùy theo logic xóa của bạn
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Báo cho server đây là AJAX request
                    }
                })
                .then(response => response.json()) // Giả định server trả về JSON
                .then(data => {
                    if (data.success) {
                        // Xử lý thành công: Ẩn hoặc xóa hàng tương ứng trên giao diện
                        const rowToRemove = document.querySelector(`[data-row-id="${itemId}"]`);
                        if (rowToRemove) {
                            rowToRemove.remove();
                        }

                        // Hiển thị thông báo thành công (tùy chọn)
                        const messageContainer = document.getElementById('message-container');
                        if (messageContainer) {
                            messageContainer.innerHTML = `<div class="alert alert-success">${data.message || 'Đã xóa thành công.'}</div>`;
                            setTimeout(() => messageContainer.innerHTML = '', 3000); // Ẩn sau 3 giây
                        }
                    } else {
                        // Xử lý lỗi
                        const messageContainer = document.getElementById('message-container');
                        if (messageContainer) {
                            messageContainer.innerHTML = `<div class="alert alert-danger">${data.error || 'Lỗi khi xóa.'}</div>`;
                            setTimeout(() => messageContainer.innerHTML = '', 3000);
                        } else {
                            alert(data.error || 'Lỗi khi xóa.');
                        }
                    }
                })
                .catch(error => {
                    console.error('Lỗi AJAX:', error);
                    alert('Đã xảy ra lỗi khi gửi yêu cầu xóa.');
                });
            }
        });
    });
});