<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('DELETE'); apiRequireAuth(); $id=apiInt($_GET['id']??null,'notification ID'); $model=new Notification(); if(!$model->getNotificationById($id,(int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Notification not found"],404); if(!$model->deleteNotification($id,(int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Failed to delete notification"],500); jsonResponse(["success"=>true,"message"=>"Notification deleted successfully","data"=>["id"=>$id]]);
?>
