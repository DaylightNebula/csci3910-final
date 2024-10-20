<?php

require_once "../model/db.php";

function create_project($owner, $title, $description) {
    global $db;
    $stmt = $db->prepare("INSERT INTO projects VALUES (LAST_INSERT_ID(), :title, :description, :owner)");
    // $stmt->bindValue(":id", count_projects());
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":owner", $owner);
    $stmt->execute();
}

function update_project($id, $title, $description) {
    global $db;
    $stmt = $db->prepare("UPDATE projects SET title=:title, description=:description WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":description", $description);
    $stmt->execute();
}

function count_projects() {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM projects");
    $stmt->execute();
    $data = $stmt->fetch();
    return $data['total'];
}

function projects_owned_by_user($id) {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(id) FROM projects WHERE owner=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data[0][0];
}

function get_project_by_id($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM projects WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
}

function get_projects_by_owner($owner) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM projects WHERE owner=:owner");
    $stmt->bindValue(":owner", $owner);
    $stmt->execute();
    return $stmt->fetchAll();
}

function delete_project($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM projects WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
}

?>