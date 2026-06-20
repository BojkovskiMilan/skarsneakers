<?php

require_once "../config/connection.php";
require_once "../models/product.php";

header("Content-Type: application/json");


$brand = isset($_GET['brand']) ? (int)$_GET['brand'] : 0;
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$sort = $_GET['sort'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 6;
$offset = ($page - 1) * $limit;

$products = getProductsAjax($conn, $brand, $category, $sort, $limit, $offset);
$total = countProductsAjax($conn, $brand, $category);

echo json_encode([
    "products" => $products,
    "total" => $total,
    "limit" => $limit
]);

?>