<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
require_once __DIR__ . "/../../models/Proposal.php";
apiRequireMethod('POST'); apiRequireRole([3]); $data=apiBody(); apiRequired($data,['proposal_id','title','description','start_date','end_date']); $proposalId=apiInt($data['proposal_id'],'proposal ID'); $title=trim($data['title']); $description=trim($data['description']); $start=apiDate($data['start_date'],'Start date'); $end=apiDate($data['end_date'],'End date'); apiDateRange($start,$end); if($title===''||$description==='') jsonResponse(["success"=>false,"message"=>"Title and description are required"],400);
$proposalModel=new Proposal(); $proposals=$proposalModel->getSupervisorProposals((int)$_SESSION['user_id']); $proposal=apiFindById($proposals,$proposalId); if(!$proposal||$proposal['status']!=='Approved') jsonResponse(["success"=>false,"message"=>"Approved proposal not found for this supervisor"],403);
$model=new ResearchProject(); if(!$model->createProject($proposalId,$title,$description,(int)$_SESSION['user_id'],$start,$end)) jsonResponse(["success"=>false,"message"=>"Failed to create research project"],500); apiLog((int)$_SESSION['user_id'],'Created research project: '.$title); jsonResponse(["success"=>true,"message"=>"Research project created successfully"],201);
?>
