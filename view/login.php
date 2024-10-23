<!DOCTYPE html>
<html>

<!-- Title -->
<head>
    <title>Login</title>
    <link rel="stylesheet" href="main.css"/>
</head>

<!-- Table and add button -->
<body>

<header><h1>Login</h1></header>

<main>
    <form action="." method="post">
        <input type="hidden" name="action" value="perform_login" >

        Username
        <input type="text" name="username">
        <br>

        Password
        <input type="text" name="password" value="">
        <br>
        
        <input type="submit" value="Login">
    </form>

    <br>
    <form action=".">
    <input type="hidden" name="action" value="create_account">
        <input type="submit" value="Create Account" >
    </form>
</main>

</body>
</html>