<?php

require_once "config/connection.php";

$errors = [];

$brandsStmt = $conn->query("SELECT id, name FROM brands");
$brands = $brandsStmt->fetchAll(PDO::FETCH_OBJ);

$categoriesStmt = $conn->query("SELECT id, name FROM categories");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_OBJ);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];

    $imageName = $_FILES["image"]["name"];
    $tmp = $_FILES["image"]["tmp_name"];

    $path = "assets/images/thumbnails/" . $imageName;

    move_uploaded_file($tmp, $path);

    $stmt = $conn->prepare("
        INSERT INTO products
        (name, price, description, brand_id, category_id, thumbnail, image)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $name,
        $price,
        $description,
        $brand_id,
        $category_id,
        $imageName,
        $imageName
    ]);

    header("Location: index.php?strana=admin_products");
    exit;
}
?>

<div class="container py-5">
    <h2 class="mb-4">Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input class="form-control mb-2" name="name" placeholder="Product name" required>
        <input class="form-control mb-2" name="price" placeholder="Price" required>
        <textarea class="form-control mb-2" name="description" placeholder="Description"></textarea>
        <select class="form-control mb-2" name="brand_id" required>
            <option value="">Select brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand->id ?>">
                    <?= $brand->name ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select class="form-control mb-2" name="category_id" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>">
                    <?= $category->name ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="mb-3">
            <label class="form-label">Product image</label>
            <input class="form-control" type="file" name="image" required>
        </div>
        <button class="btn btn-success w-100">
            Save Product
        </button>
    </form>
</div>