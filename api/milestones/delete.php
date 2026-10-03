<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Milestone.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('DELETE'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'milestone ID'); $model=new Milestone(); $item=$model->getMilestoneById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Milestone not found"],404); $project=(new ResearchProject())->getProjectById((int)$item['project_id']); if(!$project||(int)$project['supervisor_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403); if(!$model->deleteMilestone($id)) jsonResponse(["success"=>false,"message"=>"Failed to delete milestone"],500); apiLog((int)$_SESSION['user_id'],'Deleted milestone ID: '.$id); jsonResponse(["success"=>true,"message"=>"Milestone deleted successfully","data"=>["id"=>$id]]);
?>
