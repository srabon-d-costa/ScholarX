<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('GET'); apiRequireAuth(); $id=apiInt($_GET['id']??null,'notification ID'); $model=new Notification(); $item=$model->getNotificationById($id,(int)$_SESSION['user_id']); if(!$item) jsonResponse(["success"=>false,"message"=>"Notification not found"],404); jsonResponse(["success"=>true,"data"=>$item]);
?>
