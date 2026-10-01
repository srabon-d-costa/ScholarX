<?php

/*
|--------------------------------------------------------------------------
| ScholarX Authentication & Authorization
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/session.php";


/*
|--------------------------------------------------------------------------
| Check whether user is logged in
|--------------------------------------------------------------------------
*/

function checkLogin()
{
    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../auth/login.php");
        exit();
    }
}


/*
|--------------------------------------------------------------------------
| Check user role
|--------------------------------------------------------------------------
*/

function checkRole($role_id)
{
    // First make sure the user is logged in
    checkLogin();


    // Check whether role exists
    if(!isset($_SESSION['role_id']))
    {
        // Destroy invalid session
        $_SESSION = [];

        session_destroy();

        header("Location: ../auth/login.php");
        exit();
    }


    // Compare roles safely
    if((int)$_SESSION['role_id'] !== (int)$role_id)
    {
        http_response_code(403);

        echo "<h1>403 - Access Denied</h1>";
        echo "<p>You do not have permission to access this page.</p>";

        exit();
    }
}

?>