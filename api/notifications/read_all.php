<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('PUT'); apiRequireAuth(); $model=new Notification(); if(!$model->markAllAsRead((int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Failed to mark notifications as read"],500); jsonResponse(["success"=>true,"message"=>"All notifications marked as read"]);
?>
