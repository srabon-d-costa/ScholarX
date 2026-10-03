<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Milestone.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([2,3,4]); $id=apiInt($_GET['id']??null,'milestone ID'); $model=new Milestone(); $item=$model->getMilestoneById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Milestone not found"],404); $projectModel=new ResearchProject(); $project=$projectModel->getProjectById((int)$item['project_id']); if(!$project) jsonResponse(["success"=>false,"message"=>"Project not found"],404); $role=(int)$_SESSION['role_id']; $allowed=($role===4)||($role===3&&(int)$project['supervisor_id']===(int)$_SESSION['user_id']); if($role===2){$allowed=(bool)apiFindById($projectModel->getStudentProjects((int)$_SESSION['user_id']),(int)$item['project_id']);} if(!$allowed) jsonResponse(["success"=>false,"message"=>"Access denied"],403); jsonResponse(["success"=>true,"data"=>$item]);
?>
