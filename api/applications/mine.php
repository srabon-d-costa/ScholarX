<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
apiRequireMethod('GET'); apiRequireRole([2]); $model=new Application(); $data=$model->getStudentApplications((int)$_SESSION['user_id']);
jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
