<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);


$team = new TeamController();


if(!isset($_GET['id']) || !isset($_GET['team_id']))
{
    header("Location: teams.php");
    exit();
}


$id = $_GET['id'];

$team_id = $_GET['team_id'];



$result = $team->removeMember($id);


if($result)
{
    header("Location: team_details.php?id=".$team_id);
    exit();
}
else
{
    echo "Failed To Remove Member";
}

?>