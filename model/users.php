<?php

require_once "model/db.php";

function get_user_by_name($username) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();
    return $stmt->fetch();
}

function get_user_by_id($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
}

function add_user($username, $hash) {
    global $db;

    // create user
    $stmt = $db->prepare("INSERT INTO users VALUES (LAST_INSERT_ID(), :username, :hash)");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":hash", $hash);
    $stmt->execute();

    // get the assigned id
    $stmt = $db->prepare("SELECT id from users WHERE username=:username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();
    return $stmt->fetch()['id'];
} 

?>