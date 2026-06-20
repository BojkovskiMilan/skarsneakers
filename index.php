<?php
session_start();

require_once "config/connection.php";
require_once "models/product.php";
require_once "models/user.php";
require_once "models/auth.php";

$page = $_GET['strana'] ?? 'home';

$logLine = date("Y-m-d H:i:s") . " - $page\n";
file_put_contents("data/logs.txt", $logLine, FILE_APPEND);

require_once "views/layout/head.php";
require_once "views/layout/top-nav.php";

echo '<div class="page-wrapper">';

if ($page == 'home') {

    $featuredProducts = getFeaturedProducts($conn);
    require_once "views/pages/home.php";

} elseif ($page == 'products') {

    require_once "views/pages/products.php";

} elseif ($page == 'register') {

    require_once "views/pages/register.php";

} elseif ($page == 'login') {

    require_once "views/pages/login.php";

} elseif ($page == 'logout') {

    require_once "views/pages/logout.php";

} elseif ($page == 'activate') {

    require_once "views/pages/activate.php";

} elseif ($page == 'product') {

    require_once "views/pages/product.php";

}

elseif ($page == 'cart_add') {

    require_once "models/cart.php";

    $id = $_GET['id'];
    $product = getProductById($conn, $id);

    if ($product) {
        addToCart($product);
    }

    header("Location: index.php?strana=cart");
    exit;

} elseif ($page == 'cart') {

    require_once "views/pages/cart.php";

} elseif ($page == 'cart_inc') {

    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    }

    header("Location: index.php?strana=cart");
    exit;

} elseif ($page == 'cart_dec') {

    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']--;

        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: index.php?strana=cart");
    exit;

} elseif ($page == 'cart_remove') {

    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: index.php?strana=cart");
    exit;
}

elseif ($page == 'checkout') {

    require_once "models/order.php";
    require_once "models/cart.php";

    if (!isset($_SESSION['user'])) {
        header("Location: index.php?strana=login");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        header("Location: index.php?strana=cart");
        exit;
    }

    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $orderId = createOrder($conn, $userId, 1, $total);

    foreach ($cart as $item) {
        addOrderItem(
            $conn,
            $orderId,
            $item['id'],
            $item['quantity'],
            $item['price']
        );
    }

    unset($_SESSION['cart']);

    header("Location: index.php?strana=my_orders");
    exit;

} elseif ($page == 'my_orders') {

    require_once "models/order.php";

    if (!isset($_SESSION['user'])) {
        header("Location: index.php?strana=login");
        exit;
    }

    $orders = getOrdersByUser($conn, $_SESSION['user']['id']);

    require_once "views/pages/my_orders.php";

} elseif ($page == 'order_details') {

    require_once "views/pages/order_details.php";

}

elseif ($page == 'admin') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "views/pages/admin/dashboard.php";

} elseif ($page == 'admin_stats') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "views/pages/admin/stats.php";

} elseif ($page == 'admin_products') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "models/product.php";

    $products = getAllProducts($conn);
    require_once "views/pages/admin/products.php";

} elseif ($page == 'admin_product_add') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "models/product.php";
    require_once "views/pages/admin/product_add.php";

} elseif ($page == 'admin_product_edit') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "models/product.php";

    $id = $_GET['id'];
    $product = getProductById($conn, $id);

    if (!$product) {
        echo "Product not found";
        exit;
    }

    require_once "views/pages/admin/product_edit.php";

} elseif ($page == 'admin_product_delete') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?strana=admin_products");
    exit;

} elseif ($page == 'admin_users') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "models/auth.php";
    require_once "models/order.php";


    $users = getAllUsers($conn);

    $selectedUser = null;
    $userOrders = [];

    if (isset($_GET['user_id'])) {

        $selectedUser = $_GET['user_id'];
        $userOrders = getOrdersByUser($conn, $selectedUser);
    }

    require_once "views/pages/admin/users.php";
} elseif ($page == 'admin_order_complete') {

    if (!isAdmin($_SESSION['user']['role_id'])) {
        header("Location: index.php");
        exit;
    }

    require_once "models/auth.php";

    updateOrderStatus($conn, $_GET['id'], 2);

    $userId = $_GET['user_id'] ?? null;

    header("Location: index.php?strana=admin_users&user_id=" . $userId);
    exit;

} elseif ($page == 'admin_order_cancel') {

    if (!isAdmin($_SESSION['user']['role_id'])) {
        header("Location: index.php");
        exit;
    }

    require_once "models/auth.php";

    updateOrderStatus($conn, $_GET['id'], 3);

    $userId = $_GET['user_id'] ?? null;

    header("Location: index.php?strana=admin_users&user_id=" . $userId);
    exit;

} elseif ($page == 'admin_user_update_role') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
        header("Location: index.php");
        exit;
    }

    $userId = $_POST['user_id'];
    $roleId = $_POST['role_id'];

    $stmt = $conn->prepare("UPDATE users SET role_id = ? WHERE id = ?");
    $stmt->execute([$roleId, $userId]);

    header("Location: index.php?strana=admin_users");
    exit;
}

elseif ($page == 'author') {
    require_once "views/pages/author.php";

} elseif ($page == 'documentation') {
    require_once "views/pages/documentation.php";

} else {

    echo "<div class='container py-5'>404 - Stranica ne postoji</div>";
}

echo '</div>';
require_once "views/layout/footer.php";