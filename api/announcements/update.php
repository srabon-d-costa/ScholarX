<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('PUT');
apiRequireRole([1,4]);
$id=apiInt($_GET['id']??null,'announcement ID'); $data=apiBody(); apiRequired($data,['title','content','target_role']);
$title=trim($data['title']); $content=trim($data['content']); $targetRole=trim($data['target_role']);
if($title===''||$content==='') jsonResponse(["success"=>false,"message"=>"Title and content are required"],400);
if(!in_array($targetRole,['All','Student','Supervisor','Coordinator'],true)) jsonResponse(["success"=>false,"message"=>"Invalid target role"],400);
$targetDepartment=apiOptionalInt($data['target_department']??null,'target department');
$model=new Announcement(); if(!$model->getAnnouncementById($id)) jsonResponse(["success"=>false,"message"=>"Announcement not found"],404);
if(!$model->updateAnnouncement($id,$title,$content,$targetRole,$targetDepartment)) jsonResponse(["success"=>false,"message"=>"Failed to update announcement"],500);
apiLog((int)$_SESSION['user_id'],"Updated announcement ID: ".$id);
jsonResponse(["success"=>true,"message"=>"Announcement updated successfully","data"=>["id"=>$id]]);
?>
