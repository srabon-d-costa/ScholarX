<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('GET'); apiRequireAuth(); $model=new Notification(); $data=$model->getUnreadNotifications((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
