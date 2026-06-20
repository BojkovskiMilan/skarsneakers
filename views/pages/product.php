<?php
require_once "models/product.php";

$id = $_GET['id'] ?? 0;

$product = getProductById($conn, $id);

if (!$product) {
    echo "<div class='container py-5'><h3>Product not found</h3></div>";
    return;
}
?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6">
            <div class="product-image-wrapper">
                <img src="assets/images/products/<?= $product->image ?>"
                    class="img-fluid product-main-image"
                    alt="<?= htmlspecialchars($product->name) ?>">
            </div>
        </div>
        <div class="col-md-6">
            <span class="badge bg-secondary mb-2">
                <?= $product->brand_name ?>
            </span>
            <h2 class="mb-2">
                <?= $product->name ?>
            </h2>
            <p class="text-muted mb-3">
                <?= $product->category_name ?>
            </p>
            <h3 class="mb-4">
                <?= $product->price ?> €
            </h3>
            <p class="mb-4 text-secondary">
                <?= $product->description ?>
            </p>
            <div class="d-flex gap-2">
                <a href="index.php?strana=cart_add&id=<?= $product->id ?>"
                   class="btn btn-success btn-lg">
                    Add to Cart
                </a>
                <a href="index.php?strana=products"
                   class="btn btn-outline-dark btn-lg">
                    Back to Products
                </a>
            </div>
        </div>
    </div>
</div>