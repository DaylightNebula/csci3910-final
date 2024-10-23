<!DOCTYPE html>
<html>

<?php

require_once "model/db.php";
require_once "model/projects.php";

$user = get_user_by_id($id);
$project_count = projects_owned_by_user($id);
$projects = get_projects_by_owner($id);

?>

<!-- Title -->
<head>
    <title>Todo Home</title>
    <link rel="stylesheet" href="main.css"/>
</head>

<!-- Table and add button -->
<body>

<header><h1>Todo Home</h1></header>

<main>
    
    <!-- Username with logout button -->
    <form action="." method="post" style="float: right;" >
        <input type="hidden" name="action" value="logout">
        <label>Logged in as: <?php echo $user['username']; ?></label>
        <input type="submit" value="Logout">
    </form>

    <br>

    <!-- Projects Title -->
    <form>
        <input type="hidden" name="action" value="create_project">
        <input type="hidden" name="editing" value="false">
        <label>Projects: <?php echo $project_count; ?></label>
        <input type="submit" value="Create Project">
    </form>

    <!-- Projects -->
    <?php foreach ($projects as $project): ?>
        <div class="homepage_project" >
            <!-- Project Title -->
            <label style="font-size: 20px; font-weight: bold;" >Project: <?php echo $project['title']; ?></label><br>

            <div style="display: flex; flex-direction: row; float: right; margin-top: -20px; margin-right: -25px;" >
                <!-- Edit Project Button -->
                <form action="." method="post">
                    <input type="hidden" name="action" value="create_project">
                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                    <input type="hidden" name="editing" value="true">
                    <input type="hidden" name="title" value="<?php echo $project['title']; ?>">
                    <input type="hidden" name="description" value="<?php echo $project['description']; ?>">
                    <input type="submit" value="Edit Project">
                </form>

                <!-- View Project Button -->
                <form action="." method="post">
                    <input type="hidden" name="action" value="view_project">
                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                    <input type="submit" value="View Project">
                </form>

                <!-- Delete Project Button -->
                <form action="." method="post">
                    <input type="hidden" name="action" value="delete_project">
                    <input type="hidden" name="id" value="<?php echo $project['id'] ?>">
                    <input type="submit" value="Delete Project">
                </form>
            </div>

            <!-- Description -->
            <?php echo $project['description']; ?>
        </div>
    <?php endforeach; ?>

</main>

</body>
</html>