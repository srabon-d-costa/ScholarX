<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ApplicationController.php";


checkLogin();

checkRole(3); // Supervisor only



$application = new ApplicationController();



if(!isset($_GET['id']) || !isset($_GET['status']))
{
    header("Location: applications.php");
    exit();
}



$id = $_GET['id'];

$status = $_GET['status'];



if($status == "Accepted" || $status == "Rejected")
{

    $result = $application->changeStatus(
        $id,
        $status
    );


    if($result)
    {
        header("Location: applications.php");
        exit();
    }
    else
    {
        echo "Failed to update application status";
    }

}
else
{
    echo "Invalid Status";
}


?>