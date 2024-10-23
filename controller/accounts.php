<?php

require_once "model/db.php";
require_once "model/sessions.php";
require_once "model/users.php";

enum BuildAccountResult {
    case SUCCESS;
    case PASSWORD_MISMATCH;
    case USERNAME_TAKEN;
}

enum LoginResult {
    case SUCCESS;
    case FAIL;
}

function build_account($username, $password, $password_confirm) {
    // get username and password
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $password_confirm = filter_input(INPUT_POST, 'password_confirm');

    // check password
    if ($password != $password_confirm) { return BuildAccountResult::PASSWORD_MISMATCH; }

    // check if username exists
    $user = get_user_by_name($username);
    if ($user != NULL) { return BuildAccountResult::USERNAME_TAKEN; }

    // hash password and create account
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $id = add_user($username, $hash);

    // assign the current session
    assign_session($id);

    return BuildAccountResult::SUCCESS;
}

function login($username, $password) {
    // get username and password
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    // get user and validate
    $user = get_user_by_name($username);
    if ($user == NULL || !password_verify($password, $user['hash'])) {
        // $error = "Username or password is incorrect";
        // header("Location: .?action=login&error=$error");
        return LoginResult::FAIL;
    }

    // assign session
    $token = assign_session($user['id']);
    return LoginResult::SUCCESS;
}

?>