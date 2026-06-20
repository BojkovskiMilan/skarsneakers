<?php
$selectedUserId = $_GET['user_id'] ?? null;
$selectedUser = null;
$userOrders = [];

if ($selectedUserId) {

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$selectedUserId]);
    $selectedUser = $stmt->fetch(PDO::FETCH_OBJ);

    if ($selectedUser) {

        $stmt = $conn->prepare("
            SELECT o.*, s.name AS status_name
            FROM orders o
            INNER JOIN statuses s ON o.status_id = s.id
            WHERE o.user_id = ?
            ORDER BY o.id DESC
        ");

        $stmt->execute([$selectedUserId]);
        $userOrders = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Users Management</h2>
        <a href="index.php?strana=admin"
        class="btn btn-outline-dark btn-sm">
            ← Back to Dashboard
        </a>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">All Users</h5>

                    <?php foreach ($users as $user): ?>

                        <div class="border-bottom py-3">
                            <div class="mb-2">
                                <strong><?= htmlspecialchars($user->username) ?></strong><br>
                                <small class="text-muted"><?= $user->role_name ?></small>
                            </div>
                            <form method="POST"
                                  action="index.php?strana=admin_user_update_role"
                                  class="d-flex gap-2 mb-2">
                                <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                <select name="role_id" class="form-select form-select-sm">
                                    <option value="2" <?= $user->role_id == 2 ? 'selected' : '' ?>>
                                        User
                                    </option>
                                    <option value="1" <?= $user->role_id == 1 ? 'selected' : '' ?>>
                                        Admin
                                    </option>
                                </select>
                                <button class="btn btn-sm btn-dark">
                                    Update
                                </button>
                            </form>
                            <a href="index.php?strana=admin_users&user_id=<?= $user->id ?>"
                               class="btn btn-sm btn-outline-secondary w-100">
                                View Orders
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">User Orders</h5>

                    <?php if (!$selectedUser): ?>

                        <p class="text-muted">
                            Select a user to view orders.
                        </p>

                    <?php else: ?>

                        <?php if (empty($userOrders)): ?>

                            <p class="text-muted">
                                This user has no orders.
                            </p>

                        <?php else: ?>

                            <?php foreach ($userOrders as $order): ?>

                                <?php $uid = $selectedUser->id; ?>

                                <div class="border-bottom py-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Order #<?= $order->id ?></strong><br>
                                            <small class="text-muted">
                                                <?= $order->order_date ?>
                                            </small>
                                        </div>

                                        <div>
                                            <?php if ($order->status_id == 1): ?>
                                                <a href="index.php?strana=admin_order_complete&id=<?= $order->id ?>&user_id=<?= $uid ?>"
                                                   class="btn btn-sm btn-success">
                                                    Approve
                                                </a>
                                                <a href="index.php?strana=admin_order_cancel&id=<?= $order->id ?>&user_id=<?= $uid ?>"
                                                   class="btn btn-sm btn-danger">
                                                    Cancel
                                                </a>
                                            <?php elseif ($order->status_id == 2): ?>
                                                <span class="badge bg-success">
                                                    Completed
                                                </span>

                                            <?php else: ?>
                                                <span class="badge bg-danger">
                                                    Cancelled
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Total:</strong>
                                        <?= $order->total_price ?> €
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>