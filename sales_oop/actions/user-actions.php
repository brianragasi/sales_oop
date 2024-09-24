<?php

require_once "../classes/Database.php"; // Include Database.php

session_start();

include "../classes/User.php";

$user = new User;

// Register User
if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->createUser($first_name, $last_name, $username, $password);
}

// Login User
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->loginUser($username, $password);
}

?>