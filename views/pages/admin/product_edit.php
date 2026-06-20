<?php
require_once "config/connection.php";

$brandsStmt = $conn->query("SELECT id, name FROM brands");
$brands = $brandsStmt->fetchAll(PDO::FETCH_OBJ);

$categoriesStmt = $conn->query("SELECT id, name FROM categories");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_OBJ);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];

    $imageName = null;

    if (!empty($_FILES["image"]["name"])) {

        $imageName = $_FILES["image"]["name"];
        $tmp = $_FILES["image"]["tmp_name"];

        move_uploaded_file($tmp, "assets/images/thumbnails/" . $imageName);
    }

    $sql = "
        UPDATE products
        SET name = ?, price = ?, description = ?, brand_id = ?, category_id = ?
    ";

    $params = [$name, $price, $description, $brand_id, $category_id];

    if ($imageName) {
        $sql .= ", thumbnail = ?, image = ?";
        $params[] = $imageName;
        $params[] = $imageName;
    }

    $sql .= " WHERE id = ?";
    $params[] = $product->id;

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    header("Location: index.php?strana=admin_products");
    exit;
}
?>

<div class="container py-5">

    <h2 class="mb-4">Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <input class="form-control mb-2"
               name="name"
               value="<?= htmlspecialchars($product->name) ?>"
               required>

        <input class="form-control mb-2"
               name="price"
               value="<?= $product->price ?>"
               required>

        <textarea class="form-control mb-2"
                  name="description"><?= htmlspecialchars($product->description) ?></textarea>

        <select class="form-control mb-2" name="brand_id" required>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand->id ?>"
                    <?= $brand->id == $product->brand_id ? 'selected' : '' ?>>
                    <?= $brand->name ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select class="form-control mb-2" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"
                    <?= $category->id == $product->category_id ? 'selected' : '' ?>>
                    <?= $category->name ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p class="mt-3 mb-1">Current image:</p>
        <img src="assets/images/thumbnails/<?= $product->thumbnail ?>"
             width="120"
             class="mb-3 rounded shadow-sm">

        <div class="mb-3">
            <label class="form-label">Change product image</label>
            <input class="form-control" type="file" name="image">
        </div>

        <button class="btn btn-warning w-100">
            Update Product
        </button>
    </form>
</div>