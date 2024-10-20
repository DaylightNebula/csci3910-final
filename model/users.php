<?php

require_once "../model/db.php";

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

function count_users() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(id) FROM users");
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data[0][0];
}

function add_user($id, $username, $hash) {
    global $db;
    $stmt = $db->prepare("INSERT INTO users VALUES (:id, :username, :hash)");
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":hash", $hash);
    $stmt->execute();
} 

?>