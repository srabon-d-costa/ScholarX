<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ProposalController.php";


checkLogin();

checkRole(3);



$proposal = new ProposalController();



if(!isset($_GET['id']) || !isset($_GET['status']))
{
    header("Location: proposals.php");
    exit();
}



$id = $_GET['id'];

$status = $_GET['status'];



if($status != "Approved" && $status != "Rejected")
{
    header("Location: proposals.php");
    exit();
}



$result = $proposal->updateStatus(

    $id,

    $status

);



if($result)
{
    header("Location: proposals.php");
    exit();
}
else
{
    echo "Failed To Update Proposal Status";
}

?>