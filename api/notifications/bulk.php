<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('POST'); apiRequireRole([1,4]); $data=apiBody(); apiRequired($data,['user_ids','type','reference_id','message']); if(!is_array($data['user_ids'])||empty($data['user_ids'])) jsonResponse(["success"=>false,"message"=>"user_ids must be a non-empty array"],400); $ids=[]; foreach($data['user_ids'] as $id){$ids[]=apiInt($id,'user ID');} $type=trim($data['type']); $referenceId=apiInt($data['reference_id'],'reference ID'); $message=trim($data['message']); if($type===''||$message==='') jsonResponse(["success"=>false,"message"=>"Type and message are required"],400); $model=new Notification(); if(!$model->createBulkNotifications($ids,$type,$referenceId,$message)) jsonResponse(["success"=>false,"message"=>"Failed to create notifications"],500); jsonResponse(["success"=>true,"message"=>"Notifications created successfully","count"=>count($ids)],201);
?>
