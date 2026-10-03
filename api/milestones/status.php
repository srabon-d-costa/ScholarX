<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Milestone.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('PUT'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'milestone ID'); $data=apiBody(); apiRequired($data,['status']); $status=trim($data['status']); if(!in_array($status,['Pending','In Progress','Completed'],true)) jsonResponse(["success"=>false,"message"=>"Invalid milestone status"],400); $model=new Milestone(); $item=$model->getMilestoneById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Milestone not found"],404); $project=(new ResearchProject())->getProjectById((int)$item['project_id']); if(!$project||(int)$project['supervisor_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403); if(!$model->updateMilestoneStatus($id,$status)) jsonResponse(["success"=>false,"message"=>"Failed to update milestone status"],500); apiLog((int)$_SESSION['user_id'],'Changed milestone ID: '.$id.' status to '.$status); jsonResponse(["success"=>true,"message"=>"Milestone status updated","data"=>["id"=>$id,"status"=>$status]]);
?>
