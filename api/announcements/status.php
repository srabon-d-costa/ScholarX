<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('PATCH');
apiRequireRole([1,4]);
$id=apiInt($_GET['id']??null,'announcement ID'); $data=apiBody(); apiRequired($data,['is_active']);
$isActive=filter_var($data['is_active'],FILTER_VALIDATE_BOOLEAN,NULL);
if($data['is_active']!==true && $data['is_active']!==false && !in_array($data['is_active'],[0,1,'0','1','true','false'],true)) jsonResponse(["success"=>false,"message"=>"is_active must be boolean"],400);
$model=new Announcement(); if(!$model->getAnnouncementById($id)) jsonResponse(["success"=>false,"message"=>"Announcement not found"],404);
if(!$model->updateStatus($id,$isActive?1:0)) jsonResponse(["success"=>false,"message"=>"Failed to update announcement status"],500);
apiLog((int)$_SESSION['user_id'],($isActive?'Activated':'Deactivated')." announcement ID: ".$id);
jsonResponse(["success"=>true,"message"=>"Announcement status updated","data"=>["id"=>$id,"is_active"=>$isActive?1:0]]);
?>
