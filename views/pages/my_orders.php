<div class="container py-5">
    <h2 class="mb-4">Your orders</h2>
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            You don’t have any orders yet.
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <?php foreach ($orders as $order): ?>
                    <a href="index.php?strana=order_details&id=<?= $order->id ?>" class="text-decoration-none text-dark">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Order #<?= $order->id ?></h5>
                                        <p class="mb-1 text-muted">
                                            Date: <?= $order->order_date ?>
                                        </p>
                                        <span class="badge bg-secondary">
                                            <?= $order->status_name ?>
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="mb-0">
                                            <?= $order->total_price ?> €
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>