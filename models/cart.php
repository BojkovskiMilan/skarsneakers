<?php

function addToCart($product)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $id = $product->id;

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "image" => $product->thumbnail,
            "quantity" => 1
        ];
    }
}

?>