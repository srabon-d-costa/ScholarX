<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(4);

$announcement = new AnnouncementController();

if(!isset($_GET['id']) || !isset($_GET['status']))
{
    header("Location: announcements.php");
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

if($status != 0 && $status != 1)
{
    header("Location: announcements.php");
    exit();
}

$announcement->updateStatus($id, $status);

header("Location: announcements.php");
exit();

?>