<?php
// define database location
$dsn = "mysql:host=localhost;dbname=csci3910final";
$username = "todo_manager";
$password = "todo_manager_password";

// attempt to create pdo database connection
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $ex) {
    $error_message = $ex->getMessage();
    echo $error_message;
    include('error.php');
    exit();
}

?>