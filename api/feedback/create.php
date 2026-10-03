<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Feedback.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
require_once __DIR__ . "/../../models/Proposal.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('POST'); apiRequireRole([3]); $data=apiBody(); apiRequired($data,['project_id','to_user_id','message','rating']);
$projectId=apiInt($data['project_id'],'project ID'); $studentId=apiInt($data['to_user_id'],'student ID'); $message=trim($data['message']); $rating=apiInt($data['rating'],'rating',1);
if($rating>5) jsonResponse(["success"=>false,"message"=>"Rating must be between 1 and 5"],400); if($message==='') jsonResponse(["success"=>false,"message"=>"Feedback message cannot be empty"],400);
$projectModel=new ResearchProject(); $project=$projectModel->getProjectById($projectId); if(!$project) jsonResponse(["success"=>false,"message"=>"Project not found"],404); if((int)$project['supervisor_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403);
$proposalModel=new Proposal(); $proposals=$proposalModel->getSupervisorProposals((int)$_SESSION['user_id']); $proposal=apiFindById($proposals,(int)$project['proposal_id']); if(!$proposal) jsonResponse(["success"=>false,"message"=>"Project team could not be verified"],403);
$team=new Team(); $members=$team->getMembers((int)$proposal['team_id']); if(!apiFindById($members,$studentId) && !apiFindById(array_map(fn($m)=>['id'=>(int)$m['user_id']],$members),$studentId)) jsonResponse(["success"=>false,"message"=>"Student is not a member of this project team"],403);
$model=new Feedback(); if(!$model->createFeedback($projectId,(int)$_SESSION['user_id'],$studentId,$message,$rating)) jsonResponse(["success"=>false,"message"=>"Failed to create feedback"],500);
apiLog((int)$_SESSION['user_id'],'Gave feedback to user ID: '.$studentId.' for project ID: '.$projectId);
jsonResponse(["success"=>true,"message"=>"Feedback submitted successfully"],201);
?>
