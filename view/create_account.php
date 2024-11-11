<!DOCTYPE html>
<html>

<?php
$error = filter_input(INPUT_POST, 'error');
if ($error == NULL) {
    $error = filter_input(INPUT_GET, 'error');
}
?>

<!-- Title -->
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="main.css"/>
</head>

<!-- Table and add button -->
<body>

<header><h1>Create Account</h1></header>

<main>
    <?php if (isset($error)) echo $error; ?>
    <form action="." method="post" id="create_account_form">
        <input type="hidden" name="action" value="build_account" >

        Username
        <input type="text" name="username">
        <br>

        Password
        <input type="password" name="password" value="">
        <br>

        Confirm Password
        <input type="password" name="password_confirm" value="">
        <br>
        
        <input type="submit" value="Create Account">
    </form>
    
    <br>
    <form action="." >
        <input type="hidden" name="action" value="login">
        <input type="submit" value="Back to Login">
    </form>
</main>

</body>
</html>