<section class="bg-dark text-light py-5">
    <div class="container text-center py-5">
        <p class="text-uppercase text-secondary">
            Skar Sneakers
        </p>
        <h1 class="display-4 fw-bold">
            Step into style.<br>
            <span class="text-warning">Walk your story.</span>
        </h1>
        <p class="lead mt-3">
            Discover a collection of modern sneakers for every style — from performance sportswear to streetwear classics.
        </p>
        <a href="index.php?strana=products" class="btn btn-warning btn-lg mt-3">
            View Collection
        </a>
    </div>
</section>

<section class="py-4 bg-light">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4">
                <h3><?= count($featuredProducts) ?>+</h3>
                <p>Featured models</p>
            </div>
            <div class="col-md-4">
                <h3>100+</h3>
                <p>Sneaker models</p>
            </div>
            <div class="col-md-4">
                <h3>24/7</h3>
                <p>Online store</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted mb-0">Featured</p>
                <h2>Our best sneakers</h2>
            </div>
            <a href="index.php?strana=products" class="btn btn-outline-dark">
                View all sneakers →
            </a>
        </div>
        <div class="row">
            <?php foreach (array_slice($featuredProducts, 0, 3) as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="assets/images/thumbnails/<?= $product->thumbnail ?>"
                             class="card-img-top"
                             alt="<?= $product->name ?>">
                        <div class="card-body">
                            <span class="badge bg-secondary">
                                <?= $product->brand_name ?>
                            </span>
                            <h5 class="mt-2">
                                <?= $product->name ?>
                            </h5>
                            <p class="text-muted">
                                <?= substr($product->description, 0, 80) ?>...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong><?= $product->price ?> €</strong>
                                <a href="index.php?strana=product&id=<?= $product->id ?>"
                                   class="btn btn-sm btn-dark">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>