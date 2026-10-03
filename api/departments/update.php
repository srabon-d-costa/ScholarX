<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Department.php";
apiRequireMethod('PUT'); apiRequireRole([4]); $id=apiInt($_GET['id']??null,'department ID'); $data=apiBody(); apiRequired($data,['name','code','description']); $name=trim($data['name']); $code=trim($data['code']); $description=trim($data['description']); if($name===''||$code==='')jsonResponse(["success"=>false,"message"=>"Name and code are required"],400); $model=new Department(); if(!$model->getDepartmentById($id))jsonResponse(["success"=>false,"message"=>"Department not found"],404); if(!$model->updateDepartment($id,$name,$code,$description))jsonResponse(["success"=>false,"message"=>"Failed to update department"],500); apiLog((int)$_SESSION['user_id'],'Updated department ID: '.$id.' - '.$name.' ('.$code.')'); jsonResponse(["success"=>true,"message"=>"Department updated successfully","data"=>["id"=>$id]]);
?>
