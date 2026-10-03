<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('GET');
apiRequireRole([2]);
$model = new Announcement();
$data = $model->getStudentAnnouncements((int)$_SESSION['user_id']);
jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
