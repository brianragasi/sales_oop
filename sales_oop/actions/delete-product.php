<?php

session_start();

// Check if the user is logged in
if (empty($_SESSION)) {
    header("location: ../views/");
    exit;
}

include "../classes/Product.php";

$product = new Product;

// Check if product_id is provided in the GET request
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Delete the product using the Product class
    $product->deleteProduct($product_id);
} else {
    // Handle the case where product_id is not provided
    // You can redirect to an error page or display a message
    header("location: ../views/dashboard.php"); 
    exit;
}

?>