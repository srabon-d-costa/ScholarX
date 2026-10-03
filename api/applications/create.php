<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
require_once __DIR__ . "/../../models/Research.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('POST'); apiRequireRole([2]); $data=apiBody(); apiRequired($data,['opportunity_id','message']);
$opportunityId=apiInt($data['opportunity_id'],'opportunity ID'); $message=trim($data['message']);
if($message==='') jsonResponse(["success"=>false,"message"=>"Application message cannot be empty"],400);
$research=new Research(); $op=$research->getOpportunityById($opportunityId);
if(!$op) jsonResponse(["success"=>false,"message"=>"Research opportunity not found"],404);
if(isset($op['status']) && $op['status']!=='Open') jsonResponse(["success"=>false,"message"=>"This research opportunity is not open for applications"],409);
$model=new Application(); $studentId=(int)$_SESSION['user_id'];
if($model->checkApplication($opportunityId,$studentId)) jsonResponse(["success"=>false,"message"=>"You already applied for this opportunity"],409);
$id=$model->createApplication($opportunityId,$studentId,$message); if(!$id) jsonResponse(["success"=>false,"message"=>"Application failed"],500);
$studentName=$model->getStudentName($studentId); $notification=new Notification();
$notification->createNotification((int)$op['supervisor_id'],'application',$id,$studentName.' applied for your research opportunity: '.$op['title']);
apiLog($studentId,'Applied for research opportunity ID: '.$opportunityId);
jsonResponse(["success"=>true,"message"=>"Application submitted successfully","data"=>["id"=>(int)$id]],201);
?>
