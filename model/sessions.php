<?php

require_once "../model/db.php";

function assign_session($id) {
    global $db;

    // create token
    $token = session_create_id();
    setcookie("session", $token, 0, "", "localhost", true, false);

    // delete id
    $stmt = $db->prepare("DELETE FROM sessions WHERE id = :id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    // insert session token
    $stmt = $db->prepare("INSERT INTO sessions VALUES (:id, :token)");
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":token", $token);
    $stmt->execute();

    return $token;
}

function clear_session() {
    global $db;

    // get and remove ID if it exists
    $id = get_session_user_id();
    if ($id !== NULL) {
        $stmt = $db->prepare("DELETE FROM sessions WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    // remove cookie
    setcookie("session", "empty_cookie", 0, "", "localhost", true, false);
}

function get_session_user_id() {
    global $db;

    // get cookie
    if (array_key_exists('session', $_COOKIE)) {
        $token = $_COOKIE['session'];
    } else {
        $token = "empty_cookie";
    }

    // send SQL require
    $stmt = $db->prepare("SELECT * FROM sessions WHERE token = :token");
    $stmt->bindValue("token", $token);
    $stmt->execute();
    $data = $stmt->fetch();

    // if data is nothing, return nothing
    if ($data == NULL) return NULL;

    // get id
    return $data['id'];
}

?>