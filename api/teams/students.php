<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('GET'); apiRequireRole([3]); $model=new Team(); $data=$model->getStudents(); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
