<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('PUT'); apiRequireAuth(); $id=apiInt($_GET['id']??null,'notification ID'); $model=new Notification(); if(!$model->getNotificationById($id,(int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Notification not found"],404); if(!$model->markAsRead($id,(int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Failed to mark notification as read"],500); jsonResponse(["success"=>true,"message"=>"Notification marked as read","data"=>["id"=>$id]]);
?>
