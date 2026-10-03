<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Proposal.php";
require_once __DIR__ . "/../../models/Team.php";
require_once __DIR__ . "/../../models/Research.php";
apiRequireMethod('POST'); apiRequireRole([2]); $data=apiBody(); apiRequired($data,['opportunity_id','team_id','title','abstract']); $opportunityId=apiInt($data['opportunity_id'],'opportunity ID'); $teamId=apiInt($data['team_id'],'team ID'); $title=trim($data['title']); $abstract=trim($data['abstract']); $filePath=isset($data['file_path'])&&$data['file_path']!==''?trim($data['file_path']):null;
if($title===''||$abstract==='') jsonResponse(["success"=>false,"message"=>"Title and abstract are required"],400); $research=new Research(); $op=$research->getOpportunityById($opportunityId); if(!$op) jsonResponse(["success"=>false,"message"=>"Research opportunity not found"],404); $team=new Team(); $teams=$team->getStudentTeams((int)$_SESSION['user_id']); if(!apiFindById($teams,$teamId)) jsonResponse(["success"=>false,"message"=>"You are not a member of this team"],403); $model=new Proposal(); if(!$model->createProposal($opportunityId,$teamId,$title,$abstract,$filePath)) jsonResponse(["success"=>false,"message"=>"Failed to submit proposal"],500); apiLog((int)$_SESSION['user_id'],'Submitted research proposal: '.$title); jsonResponse(["success"=>true,"message"=>"Proposal submitted successfully"],201);
?>
