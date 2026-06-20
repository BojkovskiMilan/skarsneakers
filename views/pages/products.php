<?php
require_once "models/product.php";

$brands = getAllBrands($conn);
$categories = getAllCategories($conn);
?>

<div class="container py-4">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h2 class="mb-1 fw-bold">All Sneakers</h2>
                <p class="text-muted mb-0">
                    Browse our latest collection and discover your next pair.
                </p>
            </div>
            <span class="badge bg-dark px-3 py-2">
                Premium Collection
            </span>
        </div>
        <hr class="mt-3">
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 mb-3">
                <h5 class="mb-2">Filters</h5>
                <p class="text-muted small mb-3">
                    Refine your search
                </p>
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <select id="brandFilter" class="form-select">
                        <option value="0">All brands</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand->id ?>">
                                <?= $brand->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="0">All categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>">
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort</label>
                    <select id="sortFilter" class="form-select">
                        <option value="newest">Newest</option>
                        <option value="price_asc">Price ↑</option>
                        <option value="price_desc">Price ↓</option>
                    </select>
                </div>
                <button id="resetFilters" class="btn btn-outline-dark w-100 mt-2">
                    Reset filters
                </button>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Products</h4>
                <span class="text-muted small">
                    Showing results
                </span>
            </div>
            <div class="row g-3" id="productsContainer"></div>
            <div id="pagination" class="mt-4 d-flex justify-content-center gap-2"></div>
        </div>
    </div>
</div>