<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Milestone.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('POST'); apiRequireRole([3]); $data=apiBody(); apiRequired($data,['project_id','title','description','due_date']); $projectId=apiInt($data['project_id'],'project ID'); $title=trim($data['title']); $description=trim($data['description']); $due=apiDate($data['due_date'],'Due date');
$projectModel=new ResearchProject(); $project=$projectModel->getProjectById($projectId); if(!$project) jsonResponse(["success"=>false,"message"=>"Project not found"],404); if((int)$project['supervisor_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403); if($title===''||$description==='') jsonResponse(["success"=>false,"message"=>"Title and description are required"],400);
$model=new Milestone(); if(!$model->createMilestone($projectId,$title,$description,$due)) jsonResponse(["success"=>false,"message"=>"Failed to create milestone"],500); apiLog((int)$_SESSION['user_id'],'Created milestone: '.$title.' for project ID: '.$projectId); jsonResponse(["success"=>true,"message"=>"Milestone created successfully"],201);
?>
