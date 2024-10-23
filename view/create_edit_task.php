<!DOCTYPE html>
<html>

<?php

$id = filter_input(INPUT_POST, 'id');
$owning_project = filter_input(INPUT_POST, 'owning_project');
$editing = filter_input(INPUT_POST, 'editing') == "true";
$title = filter_input(INPUT_POST, 'title');
$description = filter_input(INPUT_POST, 'description');
$category = filter_input(INPUT_POST, 'category');
$status = filter_input(INPUT_POST, 'status');
$date = filter_input(INPUT_POST, 'date');

if ($editing) {
    $page_title = "Edit Task";
} else {
    $page_title = "Create Task";
}

?>

<!-- Title -->
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="main.css"/>
</head>

<!-- Table and add button -->
<body>

<header><h1><?php echo $page_title; ?></h1></header>

<main>
    
    <!-- Form to edit task -->
    <form action="." method="post" >
        <input type="hidden" name="action" value="finalize_create_edit_task">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="owning_project" value="<?php echo $owning_project; ?>">

        <label>Title</label><br>
        <textarea rows="1" cols="80" id="title" name="title" maxlength=255><?php echo $title; ?></textarea>
        <br><br><br>
        
        <label>Category</label><br>
        <textarea rows="1" cols="80" id="category" name="category" maxlength=255><?php echo $category; ?></textarea>
        <br><br><br>

        <label>Status</label><br>
        <select name="status" id="status">
            <option value="0" <?php if($status === NULL || $status == "0") { echo "selected"; } ?>">N/A</option>
            <option value="1" <?php if($status == "1") { echo "selected"; } ?>>Todo</option>
            <option value="2" <?php if($status == "2") { echo "selected"; } ?>>In Progress</option>
            <option value="3" <?php if($status == "3") { echo "selected"; } ?>>Done</option>
            <option value="4" <?php if($status == "4") { echo "selected"; } ?>>Waiting</option>
            <option value="5" <?php if($status == "5") { echo "selected"; } ?>>Canceled</option>
        </select>
        <br><br><br>
        
        <label>Date</label><br>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        <br><br><br>

        <label>Description</label><br>
        <textarea rows="5" cols="80" id="description" name="description" maxlength=65536><?php echo $description; ?></textarea>
        <br><br><br>

        <input type="submit" value="<?php echo $page_title; ?>">
    </form>

</main>

</body>
</html>