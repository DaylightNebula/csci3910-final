<!DOCTYPE html>
<html>

<?php

$id = filter_input(INPUT_POST, 'id');
$editing = filter_input(INPUT_POST, 'editing') == "true";
$title = filter_input(INPUT_POST, 'title');
$description = filter_input(INPUT_POST, 'description');

if ($editing) {
    $page_title = "Edit Project";
} else {
    $page_title = "Create Project";
}

?>

<!-- Title -->
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../main.css"/>
</head>

<!-- Table and add button -->
<body>

<header><h1><?php echo $page_title; ?></h1></header>

<main>
    
    <!-- Form to edit project -->
    <form action="." method="post" >
        <input type="hidden" name="action" value="finalize_create_edit_project">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>Title</label><br>
        <textarea rows="1" cols="80" id="title" name="title" maxlength=255><?php echo $title; ?></textarea>
        <br><br><br>

        <label>Description</label><br>
        <textarea rows="5" cols="80" id="description" name="description" maxlength=65536><?php echo $description; ?></textarea>
        <br><br><br>

        <input type="submit" value="<?php echo $page_title; ?>">
    </form>

</main>

</body>
</html>