<?php require_once "models/product.php"; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1">Products</h2>
            <p class="text-muted mb-0">
                Manage your sneaker catalog
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?strana=admin"
            class="btn btn-outline-dark">
                ← Back to Dashboard
            </a>
            <a href="index.php?strana=admin_product_add"
            class="btn btn-success">
                + Add Product
            </a>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="text"
                       id="searchInput"
                       class="form-control w-50"
                       placeholder="Search products...">
                <small class="text-muted">
                    Total: <?= count($products) ?>
                </small>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td class="text-muted"><?= $p->id ?></td>
                                <td>
                                    <img src="assets/images/thumbnails/<?= $p->thumbnail ?>"
                                         width="50"
                                         height="50"
                                         style="object-fit: cover;"
                                         class="rounded">
                                </td>
                                <td class="fw-semibold">
                                    <?= $p->name ?>
                                </td>
                                <td>
                                    <span class="badge bg-dark">
                                        <?= $p->price ?> €
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $p->brand_name ?? '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?= $p->category_name ?? '-' ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="index.php?strana=admin_product_edit&id=<?= $p->id ?>"
                                       class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        onclick="setDeleteId(<?= $p->id ?>)">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <a id="deleteBtn" href="#" class="btn btn-danger">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>

<script>

function setDeleteId(id) {
    document.getElementById("deleteBtn").href =
        "index.php?strana=admin_product_delete&id=" + id;
}
document.getElementById("searchInput").addEventListener("keyup", function () {

    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#productTable tr");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });

});

</script>