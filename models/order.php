<?php

function createOrder($conn, $userId, $statusId, $totalPrice)
{
    $query = "
        INSERT INTO orders (user_id, status_id, total_price)
        VALUES (?, ?, ?)
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$userId, $statusId, $totalPrice]);

    return $conn->lastInsertId();
}

function addOrderItem($conn, $orderId, $productId, $quantity, $price)
{
    $query = "
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($query);
    return $stmt->execute([$orderId, $productId, $quantity, $price]);
}

function getOrdersByUser($conn, $userId)
{
    $query = "
        SELECT o.*, s.name AS status_name
        FROM orders o
        INNER JOIN statuses s ON o.status_id = s.id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

?>