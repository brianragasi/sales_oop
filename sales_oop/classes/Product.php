<?php

require_once "Database.php";

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addProduct($product_name, $price, $quantity) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        $sql = "INSERT INTO products (product_name, price, quantity) VALUES (?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("sdi", $product_name, $price, $quantity);

        if ($stmt->execute()) {
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error adding product: " . $stmt->error);
        }
    }

    public function editProduct($product_id, $product_name, $price, $quantity) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        $sql = "UPDATE products SET product_name = ?, price = ?, quantity = ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("sdii", $product_name, $price, $quantity, $product_id);

        if ($stmt->execute()) {
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error editing product: " . $stmt->error);
        }
    }

    public function deleteProduct($product_id) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            header("location: ../views/dashboard.php");
            exit;
        } else {
            die("Error deleting product: " . $stmt->error);
        }
    }

    public function displayProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->db->getConnection()->query($sql);

        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        } else {
            return array(); // Return an empty array if no products are found
        }
    }

    public function displaySpecificProduct($product_id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return array(); // Return an empty array if the product is not found
        }
    }

    public function payProduct($product_id, $buy_quantity, $payment) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        // Get the current product details
        $product_details = $this->displaySpecificProduct($product_id);

        // Calculate the total price
        $total_price = $product_details['price'] * $buy_quantity;

        // Check if the payment is sufficient
        if ($payment >= $total_price) {
            // Update the product quantity
            $new_quantity = $product_details['quantity'] - $buy_quantity;
            $sql = "UPDATE products SET quantity = ? WHERE id = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param("ii", $new_quantity, $product_id);

            if ($stmt->execute()) {
                // Calculate change (if any)
                $change = $payment - $total_price;

                // Display payment success message (you can customize this part)
                echo "<p>Payment successful! Total price: $" . $total_price . "</p>";
                echo "<p>Change: $" . $change . "</p>";
                echo "<a href='../views/dashboard.php'>Go back to dashboard</a>";
                exit;
            } else {
                die("Error updating product quantity: " . $stmt->error);
            }
        } else {
            // Display insufficient payment message
            echo "<p>Insufficient payment. Please enter a valid amount.</p>";
        }
    }
}

?>