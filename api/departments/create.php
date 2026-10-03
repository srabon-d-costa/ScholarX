<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Department.php";
apiRequireMethod('POST'); apiRequireRole([4]); $data=apiBody(); apiRequired($data,['name','code','description']); $name=trim($data['name']); $code=trim($data['code']); $description=trim($data['description']); if($name===''||$code==='')jsonResponse(["success"=>false,"message"=>"Name and code are required"],400); $model=new Department(); if(!$model->createDepartment($name,$code,$description))jsonResponse(["success"=>false,"message"=>"Failed to create department"],500); apiLog((int)$_SESSION['user_id'],'Created department: '.$name.' ('.$code.')'); jsonResponse(["success"=>true,"message"=>"Department created successfully"],201);
?>
