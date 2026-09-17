<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);


if(isset($_GET['id']))
{
    $admin = new AdminController();

    $admin->deleteUser(
        $_GET['id']
    );
}


header("Location: users.php");

exit();

?>