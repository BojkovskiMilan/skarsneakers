<?php

function isAdmin() {
    return isset($_SESSION["user"]) && $_SESSION["user"]["role_id"] == 1;
}


function updateProduct($conn, $id, $name, $price, $description, $brand_id, $category_id, $thumbnail = null)
{
    if ($thumbnail) {

        $query = "
            UPDATE products
            SET name = ?, price = ?, description = ?, brand_id = ?, category_id = ?, thumbnail = ?
            WHERE id = ?
        ";

        $params = [$name, $price, $description, $brand_id, $category_id, $thumbnail, $id];

    } else {

        $query = "
            UPDATE products
            SET name = ?, price = ?, description = ?, brand_id = ?, category_id = ?
            WHERE id = ?
        ";

        $params = [$name, $price, $description, $brand_id, $category_id, $id];
    }

    $stmt = $conn->prepare($query);
    return $stmt->execute($params);
}

function getAllUsers($conn)
{
    $stmt = $conn->query("
        SELECT u.*, r.name AS role_name
        FROM users u
        INNER JOIN roles r ON u.role_id = r.id
        ORDER BY u.id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function updateOrderStatus($conn, $orderId, $statusId)
{
    $stmt = $conn->prepare("
        UPDATE orders
        SET status_id = ?
        WHERE id = ?
    ");

    return $stmt->execute([$statusId, $orderId]);
}

?>