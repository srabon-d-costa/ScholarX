<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Feedback.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
require_once __DIR__ . "/../../models/Proposal.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('GET'); apiRequireRole([2,3,4]); $projectId=apiInt($_GET['project_id']??null,'project ID'); $projectModel=new ResearchProject(); $project=$projectModel->getProjectById($projectId); if(!$project) jsonResponse(["success"=>false,"message"=>"Project not found"],404); $role=(int)$_SESSION['role_id']; $allowed=false;
if($role===4 || ($role===3 && (int)$project['supervisor_id']===(int)$_SESSION['user_id'])) $allowed=true;
if($role===2){ $studentProjects=$projectModel->getStudentProjects((int)$_SESSION['user_id']); $allowed=(bool)apiFindById($studentProjects,$projectId); }
if(!$allowed) jsonResponse(["success"=>false,"message"=>"Access denied"],403); $model=new Feedback(); $data=$model->getProjectFeedback($projectId); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
