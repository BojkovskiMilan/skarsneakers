<nav class="navbar navbar-dark bg-dark px-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php?strana=home">
            Skar Sneakers
        </a>
        <div class="d-flex align-items-center gap-4">
            <a href="index.php?strana=products" class="text-light text-decoration-none nav-link-custom">
                Products
            </a>
            <a href="index.php?strana=author" class="text-light text-decoration-none nav-link-custom">
                About
            </a>
            <a href="dokumentacija.pdf" target="_blank" class="text-light text-decoration-none nav-link-custom">
                Docs
            </a>
            <?php if (isset($_SESSION["user"])): ?>
                <div class="d-flex align-items-center gap-3 ms-3 ps-3 border-start border-secondary">
                    <span class="text-warning fw-semibold">
                        👤 <?= $_SESSION["user"]["username"] ?>
                    </span>
                    <?php if ($_SESSION["user"]["role_id"] != 1): ?>
                        <a href="index.php?strana=my_orders" class="text-light text-decoration-none nav-link-custom">
                            Orders
                        </a>
                        <a href="index.php?strana=cart"
                           class="text-light text-decoration-none position-relative nav-link-custom">
                            Cart
                            <?php
                                $cartCount = 0;
                                if (isset($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $item) {
                                        $cartCount += $item['quantity'];
                                    }
                                }
                            ?>
                            <?php if ($cartCount > 0): ?>
                                <span class="badge bg-warning text-dark ms-1">
                                    <?= $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($_SESSION["user"]["role_id"] == 1): ?>
                        <div class="d-flex align-items-center gap-3 ms-3 ps-3 border-start border-info">
                            <a href="index.php?strana=admin" class="text-info text-decoration-none fw-semibold">
                                Dashboard
                            </a>
                            <a href="index.php?strana=my_orders" class="text-light text-decoration-none nav-link-custom">
                                Orders
                            </a>
                            <a href="index.php?strana=cart" class="text-light text-decoration-none nav-link-custom position-relative">
                                Cart
                                <?php
                                    $cartCount = 0;
                                    if (isset($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $item) {
                                            $cartCount += $item['quantity'];
                                        }
                                    }
                                ?>
                                <?php if ($cartCount > 0): ?>
                                    <span class="badge bg-warning text-dark ms-1">
                                        <?= $cartCount ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="index.php?strana=logout" class="text-light text-decoration-none ms-3">
                    Logout
                </a>
                <?php else: ?>
                <div class="d-flex align-items-center gap-3">
                    <a href="index.php?strana=login" class="text-light text-decoration-none nav-link-custom">
                        Login
                    </a>
                    <a href="index.php?strana=register" class="text-light text-decoration-none nav-link-custom">
                        Register
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>