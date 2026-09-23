<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(4);

$announcement = new AnnouncementController();

if(!isset($_GET['id']))
{
    header("Location: announcements.php");
    exit();
}

$id = $_GET['id'];

$result = $announcement->deleteAnnouncement($id);

if($result)
{
    header("Location: announcements.php");
    exit();
}

echo "Failed to delete announcement";

?>