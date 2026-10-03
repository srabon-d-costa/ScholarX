<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('POST'); apiRequireRole([3]); $data=apiBody(); apiRequired($data,['name','description']); $name=trim($data['name']); $description=trim($data['description']); if($name===''||$description==='')jsonResponse(["success"=>false,"message"=>"Name and description are required"],400); $model=new Team(); if(!$model->createTeam($name,$description,(int)$_SESSION['user_id']))jsonResponse(["success"=>false,"message"=>"Failed to create team"],500); apiLog((int)$_SESSION['user_id'],'Created research team: '.$name); jsonResponse(["success"=>true,"message"=>"Research team created successfully"],201);
?>
