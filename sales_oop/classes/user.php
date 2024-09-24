<?php

require_once "Database.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createUser($first_name, $last_name, $username, $password) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $password);

        if ($stmt->execute()) {
            header("location: ../views/");
            exit;
        } else {
            die("Error creating user: " . $stmt->error);
        }
    }

    public function loginUser($username, $password) {
        // Sanitize user input (implementation not shown here for brevity)
        // ...

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("location: ../views/dashboard.php"); // Redirect to dashboard after successful login
                exit;
            } else {
                // Handle incorrect password
                echo "Incorrect password."; 
            }
        } else {
            // Handle username not found
            echo "Username not found."; 
        }
    }
}

?>