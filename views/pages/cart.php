<?php
require_once "models/product.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
?>
    <div class="container py-5 text-center">
        <div class="py-5">
            <h3 class="mb-3">Your cart is empty</h3>
            <p class="text-muted mb-4">
                You haven’t added any products yet.
            </p>
            <a href="index.php?strana=products" class="btn btn-dark">
                Browse sneakers
            </a>
        </div>
    </div>
<?php
    return;
}

$cart = $_SESSION['cart'];
$total = 0;
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Your cart</h2>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($cart as $item): ?>

                <?php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <div class="card mb-3 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="assets/images/thumbnails/<?= $item['image'] ?>"
                                 class="img-fluid p-2"
                                 alt="<?= $item['name'] ?>">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5><?= $item['name'] ?></h5>
                                <p class="text-muted mb-1">
                                    Price: <?= $item['price'] ?> €
                                </p>
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <a href="index.php?strana=cart_dec&id=<?= $item['id'] ?>"
                                       class="btn btn-sm btn-outline-dark">-</a>

                                    <span class="px-2"><?= $item['quantity'] ?></span>
                                    <a href="index.php?strana=cart_inc&id=<?= $item['id'] ?>"
                                       class="btn btn-sm btn-outline-dark">+</a>
                                </div>
                                <p>
                                    <strong>Subtotal: <?= $subtotal ?> €</strong>
                                </p>
                                <a href="index.php?strana=cart_remove&id=<?= $item['id'] ?>"
                                   class="btn btn-sm btn-danger">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h4>Order summary</h4>
                <hr>
                <h3><?= $total ?> €</h3>
                <a href="index.php?strana=checkout" class="btn btn-success w-100 mt-3">
                    Checkout
                </a>
                <a href="index.php?strana=products" class="btn btn-outline-dark w-100 mt-2">
                    Continue shopping
                </a>
            </div>
        </div>
    </div>
</div>