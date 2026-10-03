<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
require_once __DIR__ . "/../../models/Research.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('PUT'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'application ID'); $data=apiBody(); apiRequired($data,['status']); $status=trim($data['status']);
if(!in_array($status,['Accepted','Rejected'],true)) jsonResponse(["success"=>false,"message"=>"Invalid application status"],400);
$model=new Application(); $item=$model->getApplicationById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Application not found"],404);
$research=new Research(); $op=$research->getOpportunityById((int)$item['opportunity_id']); if(!$op || (int)$op['supervisor_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403);
if(!$model->updateApplicationStatus($id,$status)) jsonResponse(["success"=>false,"message"=>"Failed to update application status"],500);
$notification=new Notification(); $notification->createNotification((int)$item['student_id'],'application',$id,'Your application for "'.$op['title'].'" was '.$status.'.');
apiLog((int)$_SESSION['user_id'],$status.' application ID: '.$id);
jsonResponse(["success"=>true,"message"=>"Application status updated","data"=>["id"=>$id,"status"=>$status]]);
?>
