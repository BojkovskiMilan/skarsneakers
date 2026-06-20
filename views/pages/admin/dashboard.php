<?php
    if (!isset($_SESSION["user"]) || !isAdmin($_SESSION["user"]["role_id"])) {
        header("Location: index.php?strana=home");
        exit;
    }

    require_once "config/connection.php";

    $totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
?>

    <div class="container py-5">
        <div class="mb-4">
            <h2 class="mb-1">Admin Dashboard</h2>
            <p class="text-muted mb-0">
                Welcome, <?= htmlspecialchars($_SESSION["user"]["username"]) ?>
            </p>
        </div>
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-muted mb-1">Total Users</h6>
                    <h3 class="mb-0"><?= $totalUsers ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-muted mb-1">Total Products</h6>
                    <h3 class="mb-0"><?= $totalProducts ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="mb-0"><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="index.php?strana=admin_stats"
                class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 dashboard-card">
                        <div class="card-body">
                            <h5 class="mb-1">Statistics</h5>
                            <p class="text-muted mb-0">
                                Traffic and user activity overview
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="index.php?strana=admin_products"
                class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 dashboard-card">
                        <div class="card-body">
                            <h5 class="mb-1">Products</h5>
                            <p class="text-muted mb-0">
                                Add, edit and manage products
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="index.php?strana=admin_users"
                class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 dashboard-card">
                        <div class="card-body">
                            <h5 class="mb-1">Users</h5>
                            <p class="text-muted mb-0">
                                Manage accounts and roles
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>