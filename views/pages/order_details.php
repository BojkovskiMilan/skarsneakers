<?php
require_once "models/order.php";
require_once "models/product.php";

$orderId = $_GET["id"] ?? 0;
$userId = $_SESSION["user"]["id"] ?? 0;

$query = "
    SELECT o.*, s.name AS status_name
    FROM orders o
    INNER JOIN statuses s ON o.status_id = s.id
    WHERE o.id = ? AND o.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->execute([$orderId, $userId]);

$order = $stmt->fetch(PDO::FETCH_OBJ);

if (!$order) {
    echo "<div class='container py-5'>Order not found.</div>";
    return;
}

$queryItems = "
    SELECT oi.*, p.name, p.thumbnail
    FROM order_items oi
    INNER JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";

$stmt = $conn->prepare($queryItems);
$stmt->execute([$orderId]);

$items = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container py-5">

    <h2 class="mb-3">Order #<?= $order->id ?></h2>

    <p class="text-muted">
        Date: <?= $order->order_date ?><br>
        Status:
        <span class="badge bg-secondary">
            <?= $order->status_name ?>
        </span>
    </p>

    <hr>
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($items as $item): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="assets/images/thumbnails/<?= $item->thumbnail ?>"
                                 class="img-fluid p-2"
                                 alt="<?= htmlspecialchars($item->name) ?>">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5><?= $item->name ?></h5>
                                <p class="mb-1">
                                    Quantity: <?= $item->quantity ?>
                                </p>
                                <p class="mb-0">
                                    Price: <?= $item->price ?> €
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h4>Total</h4>
                <h3><?= $order->total_price ?> €</h3>
            </div>
        </div>
    </div>
</div>