<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('POST'); apiRequireRole([1,4]); $data=apiBody(); apiRequired($data,['user_id','type','reference_id','message']); $userId=apiInt($data['user_id'],'user ID'); $referenceId=apiInt($data['reference_id'],'reference ID'); $type=trim($data['type']); $message=trim($data['message']); if($type===''||$message==='') jsonResponse(["success"=>false,"message"=>"Type and message are required"],400); $model=new Notification(); if(!$model->createNotification($userId,$type,$referenceId,$message)) jsonResponse(["success"=>false,"message"=>"Failed to create notification"],500); jsonResponse(["success"=>true,"message"=>"Notification created successfully"],201);
?>
