<?php

// Hàm lấy thông tin sản phẩm từ ID
function getProductById($conn, $productId) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $result = executeQuery($conn, $sql, [$productId], 'i');
    return fetchRow($result);
}

// Hàm thêm sản phẩm vào giỏ hàng
function addToCart($productId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

// Hàm cập nhật số lượng sản phẩm trong giỏ hàng
function updateCartItem($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        } else {
            unset($_SESSION['cart'][$productId]); // Xóa khỏi giỏ nếu số lượng <= 0
        }
    }
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Hàm lấy toàn bộ nội dung giỏ hàng
function getCartItems($conn) {
    $cartItems = [];
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = getProductById($conn, $productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
    }
    return $cartItems;
}

// Hàm tính tổng tiền của giỏ hàng
function getCartTotal($conn) {
    $total = 0;
    $cartItems = getCartItems($conn);
    foreach ($cartItems as $item) {
        $total += $item['product']['price'] * $item['quantity'];
    }
    return $total;
}

// Hàm xóa toàn bộ giỏ hàng
function clearCart() {
    unset($_SESSION['cart']);
}

?>