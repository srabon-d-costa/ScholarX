<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Department.php";
apiRequireMethod('DELETE'); apiRequireRole([4]); $id=apiInt($_GET['id']??null,'department ID'); $model=new Department(); if(!$model->getDepartmentById($id))jsonResponse(["success"=>false,"message"=>"Department not found"],404); if(!$model->deleteDepartment($id))jsonResponse(["success"=>false,"message"=>"Failed to delete department"],500); apiLog((int)$_SESSION['user_id'],'Deleted department ID: '.$id); jsonResponse(["success"=>true,"message"=>"Department deleted successfully","data"=>["id"=>$id]]);
?>
