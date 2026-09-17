<?php

function checkLogin()
{
    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../auth/login.php");
        exit();
    }
}


function checkRole($role_id)
{
    if($_SESSION['role_id'] != $role_id)
    {
        header("Location: ../auth/login.php");
        exit();
    }
}

?>