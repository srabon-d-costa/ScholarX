<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";


checkLogin();

checkRole(3);



$research = new ResearchController();



if(!isset($_GET['id']))
{
    header("Location: manage.php");
    exit();
}



$id = $_GET['id'];



$result = $research->deleteOpportunity($id);



if($result)
{
    header("Location: manage.php");
    exit();
}
else
{
    echo "Failed to Delete Research Opportunity";
}

?>