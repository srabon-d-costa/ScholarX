<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Admin.php";
apiRequireMethod('GET'); apiRequireRole([1]); $id=apiInt($_GET['id']??null,'user ID'); $model=new Admin(); $data=$model->getUserById($id); if(!$data)jsonResponse(["success"=>false,"message"=>"User not found"],404); jsonResponse(["success"=>true,"data"=>$data]);
?>
