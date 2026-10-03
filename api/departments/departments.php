<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Department.php";
apiRequireMethod('GET'); apiRequireAuth(); $model=new Department(); $data=$model->getAllDepartments(); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
