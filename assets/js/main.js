document.addEventListener("DOMContentLoaded", function () {

    const brandFilter = document.querySelector("#brandFilter");
    const categoryFilter = document.querySelector("#categoryFilter");
    const sortFilter = document.querySelector("#sortFilter");
    const applyBtn = document.querySelector("#applyFilters");

    const productsContainer = document.querySelector("#productsContainer");

    let currentPage = 1;

    function loadProducts(page = 1) {

        const brand = brandFilter ? brandFilter.value : 0;
        const category = categoryFilter ? categoryFilter.value : 0;
        const sort = sortFilter ? sortFilter.value : "";

        fetch(`ajax/products.php?brand=${brand}&category=${category}&sort=${sort}&page=${page}`)
            .then(res => res.json())
            .then(data => {

                productsContainer.innerHTML = "";

                if (data.products.length === 0) {
                    productsContainer.innerHTML = `
                        <p class="text-muted">Nema proizvoda za izabrani filter.</p>
                    `;
                    return;
                }

                data.products.forEach(product => {

                    productsContainer.innerHTML += `
                        <div class="col-md-4 mb-4">

                            <div class="card h-100 shadow-sm">

                                <img class="product-img" src="assets/images/thumbnails/${product.thumbnail}"
                                     class="card-img-top"
                                     alt="${product.name}">

                                <div class="card-body">

                                    <span class="badge bg-secondary">
                                        ${product.brand_name}
                                    </span>

                                    <h5 class="mt-2">
                                        ${product.name}
                                    </h5>

                                    <p class="text-muted small product-desc">
                                        ${product.description.substring(0, 60)}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <strong>${product.price} €</strong>

                                        <a href="index.php?strana=product&id=${product.id}"
                                           class="btn btn-sm btn-dark">
                                            Details
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>
                    `;
                });

                renderPagination(data.total, data.limit, page);
            });
    }

    function renderPagination(total, limit, page) {

        const paginationContainer = document.querySelector("#pagination");
        if (!paginationContainer) return;

        let pages = Math.ceil(total / limit);

        paginationContainer.innerHTML = "";

        for (let i = 1; i <= pages; i++) {

            paginationContainer.innerHTML += `
                <button class="btn btn-sm ${i === page ? 'btn-dark' : 'btn-outline-dark'}"
                        data-page="${i}">
                    ${i}
                </button>
            `;
        }

        document.querySelectorAll("#pagination button").forEach(btn => {
            btn.addEventListener("click", function () {
                loadProducts(this.dataset.page);
            });
        });
    }

    const resetBtn = document.querySelector("#resetFilters");

    if (resetBtn) {
    resetBtn.addEventListener("click", function () {

        if (brandFilter) brandFilter.value = 0;
        if (categoryFilter) categoryFilter.value = 0;
        if (sortFilter) sortFilter.value = "newest";

        loadProducts(1);
        });
    }

    if (brandFilter) {
        brandFilter.addEventListener("change", function () {
            loadProducts(1);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function () {
            loadProducts(1);
        });
    }

    if (sortFilter) {
        sortFilter.addEventListener("change", function () {
            loadProducts(1);
        });
    }

    loadProducts();
    
});