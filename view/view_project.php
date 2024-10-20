<!DOCTYPE html>
<html>

<?php

require_once "../model/db.php";
require_once "../model/projects.php";
require_once "../model/sessions.php";
require_once "../model/tasks.php";

$id = get_session_user_id();
$user = get_user_by_id($id);
$project_id = filter_input(INPUT_POST, 'id');
if ($project_id === NULL) { $project_id = filter_input(INPUT_GET, 'id'); }
$project = get_project_by_id($project_id);
$tasks = get_tasks_by_project($project_id);

?>

<!-- Define Title and Style -->
<head>
    <title>View Project: <?php echo $project['title'] ?></title>
    <link rel="stylesheet" href="../main.css"/>
</head>

<body>

<!-- Title -->
<header><h1>View Project: <?php echo $project['title'] ?></h1></header>

<!-- Add project description and table of tasks -->
<main>

    <!-- Username with logout button -->
    <div style="display: flex; flex-direction: row;">
        <label>Logged in as: <?php echo $user['username']; ?></label>
        
        <form action="." method="post" >
            <input type="hidden" name="action" value="homepage">
            <input type="submit" value="Homepage">
        </form>
        
        <form action="." method="post" >
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Logout">
        </form>
    </div>

    <!-- Description -->
    <p><?php echo $project['description'] ?></p>
    <br>

    <!-- Tasks header + add task button -->
    <form action="." method="post" >
        <input type="hidden" name="action" value="create_task">
        <input type="hidden" name="editing" value="false">
        <input type="hidden" name="owning_project" value="<?php echo $project_id; ?>">
        <label style="font-size: 20px; font-weight: bold;" >Tasks: <?php echo sizeof(get_tasks_by_project($project_id)) ?></label>
        <input type="submit" value="Create Task">
    </form><br>

    <!-- Tasks table -->
    <table style="width: 100%" >
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($tasks as $task): ?>
            <tr>
                <!-- Add the main information -->
                <th><?php echo $task['title'] ?></th>
                <th><?php echo $task['description'] ?></th>
                <th><?php echo $task['category'] ?></th>
                <th><?php echo $task['status'] ?></th>
                <th><?php echo $task['due_date'] ?></th>

                <!-- Add actions buttons -->
                <th style="display: flex; flex-direction: row;" >

                    <!-- Edit task button -->
                    <form action="." method="post">
                        <input type="hidden" name="action" value="create_task">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="owning_project" value="<?php echo $task['owning_project']; ?>">
                        <input type="hidden" name="editing" value="true">
                        <input type="hidden" name="title" value="<?php echo $task['title']; ?>">
                        <input type="hidden" name="description" value="<?php echo $task['description']; ?>">
                        <input type="hidden" name="date" value="<?php echo $task['due_date']; ?>">
                        <input type="hidden" name="category" value="<?php echo $task['category']; ?>">
                        <input type="hidden" name="status" value="<?php echo $task['status']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    
                    <!-- Delete task button -->
                    <form action="." method="post">
                    <input type="hidden" name="action" value="remove_task">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="owning_project" value="<?php echo $task['owning_project']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </th>
            </tr>
        <?php endforeach; ?>
    </table>

</main>

</body>
</html>