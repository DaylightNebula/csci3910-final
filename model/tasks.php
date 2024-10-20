<?php

function get_tasks_by_project($project_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM tasks WHERE owning_project=:id");
    $stmt->bindValue(":id", $project_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function create_task($owning_project, $title, $description, $date, $category, $status) {
    global $db;
    $stmt = $db->prepare("INSERT INTO tasks VALUES (LAST_INSERT_ID(), :title, :description, :owner, :date, :category, :status)");
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":owner", $owning_project);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":category", $category);
    $stmt->bindValue(":status", $status);
    $stmt->execute();
}

function update_task($id, $title, $description, $date, $category, $status) {
    global $db;
    $stmt = $db->prepare("UPDATE tasks SET title=:title, description=:description, due_date=:date, category=:category, status=:status WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":category", $category);
    $stmt->bindValue(":status", $status);
    $stmt->execute();
}

function remove_task($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM tasks WHERE id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
}

?>