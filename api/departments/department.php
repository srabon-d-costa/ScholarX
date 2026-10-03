<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Department.php";
apiRequireMethod('GET'); apiRequireAuth(); $id=apiInt($_GET['id']??null,'department ID'); $model=new Department(); $data=$model->getDepartmentById($id); if(!$data)jsonResponse(["success"=>false,"message"=>"Department not found"],404); jsonResponse(["success"=>true,"data"=>$data]);
?>
