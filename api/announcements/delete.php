<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('DELETE');
apiRequireRole([1,4]);
$id=apiInt($_GET['id']??null,'announcement ID'); $model=new Announcement(); if(!$model->getAnnouncementById($id)) jsonResponse(["success"=>false,"message"=>"Announcement not found"],404);
if(!$model->deleteAnnouncement($id)) jsonResponse(["success"=>false,"message"=>"Failed to delete announcement"],500);
apiLog((int)$_SESSION['user_id'],"Deleted announcement ID: ".$id);
jsonResponse(["success"=>true,"message"=>"Announcement deleted successfully","data"=>["id"=>$id]]);
?>
