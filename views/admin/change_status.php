<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);


if(isset($_GET['id']) && isset($_GET['status']))
{
    $admin = new AdminController();

    $admin->changeStatus(
        $_GET['id'],
        $_GET['status']
    );
}


header("Location: users.php");

exit();

?>