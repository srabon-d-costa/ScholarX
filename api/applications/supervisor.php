<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
apiRequireMethod('GET'); apiRequireRole([3]); $model=new Application(); $data=$model->getApplicationsBySupervisor((int)$_SESSION['user_id']);
jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
