<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Milestone.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([2,3,4]); $projectId=apiInt($_GET['project_id']??null,'project ID'); $projectModel=new ResearchProject(); $project=$projectModel->getProjectById($projectId); if(!$project) jsonResponse(["success"=>false,"message"=>"Project not found"],404); $role=(int)$_SESSION['role_id']; $allowed=($role===4)||($role===3&&(int)$project['supervisor_id']===(int)$_SESSION['user_id']); if($role===2){$allowed=(bool)apiFindById($projectModel->getStudentProjects((int)$_SESSION['user_id']),$projectId);} if(!$allowed) jsonResponse(["success"=>false,"message"=>"Access denied"],403); $model=new Milestone(); $data=$model->getProjectMilestones($projectId); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
