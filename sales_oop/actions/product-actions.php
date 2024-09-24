<?php

session_start();

include "../classes/Product.php";

$product = new Product;

// Add Product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $product->addProduct($product_name, $price, $quantity);
}

// Edit Product
if (isset($_POST['edit_product'])) {
    $product_id = $_GET['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $product->editProduct($product_id, $product_name, $price, $quantity);
}

// Delete Product
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $product->deleteProduct($product_id);
}

// Pay Product
if (isset($_POST['pay_product'])) {
    $product_id = $_GET['product_id'];
    $buy_quantity = $_POST['buy_quantity'];
    $payment = $_POST['payment'];

    $product->payProduct($product_id, $buy_quantity, $payment);
}

?>