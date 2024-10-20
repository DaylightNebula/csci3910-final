<?php

require_once "../model/db.php";
require_once "../model/projects.php";
require_once "../model/sessions.php";
require_once "../model/tasks.php";
require_once "../model/users.php";

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch($action) {
    // go to homepage, only go to homepage if we have a valid login session
    case "homepage":
        $id = get_session_user_id();

        if ($id !== NULL) { 
            include("../view/homepage.php");
        } else { 
            header("Location: .?action=login");
        }
        break;
    
    // display login and create account pages when asked
    case "login":
        include ("../view/login.php");
        break;
    case "create_account":
        include ("../view/create_account.php");
        break;
    
    // build an account when asked from a username, password, and password confirmation
    // fails, returning with an error if the passwords do not match or the username is taken
    case "build_account":
        // get username and password
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $password_confirm = filter_input(INPUT_POST, 'password_confirm');

        // check password
        if ($password != $password_confirm) {
            $error = "Passwords must match!";
            header("Location: .?action=create_account&error=$error");
            break;
        }

        // check if username exists
        $user = get_user_by_name($username);
        if ($user != NULL) {
            $error = "User with that username already exists";
            header("Location: .?action=create_account&error=$error");
            break;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);  // create password hash
        $id = count_users();                                // count users to get ID
        add_user($id, $username, $hash);                    // insert new user
        assign_session($id);                                // create session token
        header("Location: .?action=homepage");
        break;
    
    // allows a user to login with a username and password
    // fails, returning to the login page with an error if 
    // the username does not exist or the password does pass validation
    case "perform_login":
        // get username and password
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        // get user and validate
        $user = get_user_by_name($username);
        if ($user == NULL || !password_verify($password, $user['hash'])) {
            $error = "Username or password is incorrect";
            header("Location: .?action=login&error=$error");
            break;
        }

        // assign session
        $token = assign_session($user['id']);
        header("Location: .?action=homepage");
        break;
    
    // when asked, clear the current session and return to the login page
    case "logout":
        clear_session();
        header("Location: .?action=login");
        break;
    
    // display the create or edit project screen
    case "create_project":
        include "../view/create_edit_project.php";
        break;
    
    // when asked finalize the creation or editing of a project
    // when no project id is given, a new project is created
    // if a project id is given, the project with that id is edited
    case "finalize_create_edit_project":
        // read in inputs and get session id
        $id = get_session_user_id();
        $project_id = filter_input(INPUT_POST, "id");
        $title = filter_input(INPUT_POST, 'title');
        $description = filter_input(INPUT_POST, 'description');

        // create or update depending if a project id was given
        if (strlen($project_id) > 0) {
            update_project($project_id, $title, $description);
        } else {
            create_project($id, $title, $description);
        }

        // return to homepage
        header("Location: .?action=homepage");
        break;
    
    // when asked, finalize the creation or editing of a task
    // when no task id is given, a new task is created
    // otherwise, the task is updated with the given title and description
    case "finalize_create_edit_task":
        // read in inputs and session id
        $id = get_session_user_id();
        $task_id = filter_input(INPUT_POST, "id");
        $owning_project = filter_input(INPUT_POST, "owning_project");
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $status = filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT);
        $date = filter_input(INPUT_POST, "date");
        $category = filter_input(INPUT_POST, "category");

        // create or update task depending on if a task id was given
        if (strlen($task_id) > 0) {
            update_task($task_id, $title, $description, $date, $category, $status);
        } else {
            create_task($owning_project, $title, $description, $date, $category, $status);
        }

        // return to the view project screen
        header("Location: .?action=view_project&id=$owning_project");
        break;
    
    // when asked, delete a project with the given project id
    case "delete_project":
        // read session and project id
        $id = get_session_user_id();
        $project_id = filter_input(INPUT_POST, 'id');

        // delete the project and return to the homepage
        delete_project($project_id);
        header("Location: .?action=homepage");
        break;
    
    // when asked, remove a task with the given task id from the given owning project
    case "remove_task":
        // read task id and owning project
        $task_id = filter_input(INPUT_POST, "id");
        $owning_project = filter_input(INPUT_POST, "owning_project");

        // remove the task and return to the view project screen
        remove_task($task_id);
        header("Location: .?action=view_project&id=$owning_project");
        break;
    
    // display the view project and create tasks screens
    case "view_project":
        include "../view/view_project.php";
        break;
    case "create_task":
        include "../view/create_edit_task.php";
        break;
}

?>