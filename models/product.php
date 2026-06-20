<?php

function getFeaturedProducts($conn)
{
    $query = "
        SELECT p.*, b.name AS brand_name, c.name AS category_name
        FROM products p
        INNER JOIN brands b ON p.brand_id = b.id
        INNER JOIN categories c ON p.category_id = c.id
        WHERE p.featured = 1
        ORDER BY p.created_at DESC
        LIMIT 3
    ";

    return $conn->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function getAllProducts($conn)
{
    $query = "
        SELECT p.*, b.name AS brand_name, c.name AS category_name
        FROM products p
        INNER JOIN brands b ON p.brand_id = b.id
        INNER JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC
    ";

    return $conn->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function getProductById($conn, $id)
{
    $query = "
        SELECT p.*, b.name AS brand_name, c.name AS category_name
        FROM products p
        INNER JOIN brands b ON p.brand_id = b.id
        INNER JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getProductsAjax($conn, $brand, $category, $sort, $limit, $offset)
{
    $limit = (int)$limit;
    $offset = (int)$offset;

    $query = "
        SELECT p.*, b.name AS brand_name, c.name AS category_name
        FROM products p
        INNER JOIN brands b ON p.brand_id = b.id
        INNER JOIN categories c ON p.category_id = c.id
        WHERE 1=1
    ";

    $params = [];

    if ($brand != 0) {
        $query .= " AND p.brand_id = ?";
        $params[] = $brand;
    }

    if ($category != 0) {
        $query .= " AND p.category_id = ?";
        $params[] = $category;
    }

    if ($sort == "price_asc") {
        $query .= " ORDER BY p.price ASC";
    } else if ($sort == "price_desc") {
        $query .= " ORDER BY p.price DESC";
    } else {
        $query .= " ORDER BY p.created_at DESC";
    }

    $query .= " LIMIT $limit OFFSET $offset";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function countProductsAjax($conn, $brand, $category)
{
    $query = "SELECT COUNT(*) FROM products WHERE 1=1";
    $params = [];

    if ($brand != 0) {
        $query .= " AND brand_id = ?";
        $params[] = $brand;
    }

    if ($category != 0) {
        $query .= " AND category_id = ?";
        $params[] = $category;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchColumn();
}


function getAllBrands($conn)
{
    $query = "SELECT * FROM brands ORDER BY name ASC";
    return $conn->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function getAllCategories($conn)
{
    $query = "SELECT * FROM categories ORDER BY name ASC";
    return $conn->query($query)->fetchAll(PDO::FETCH_OBJ);
}