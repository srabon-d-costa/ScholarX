<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Proposal.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('GET'); apiRequireRole([2]); $teamId=apiInt($_GET['team_id']??null,'team ID'); $team=new Team(); if(!apiFindById($team->getStudentTeams((int)$_SESSION['user_id']),$teamId)) jsonResponse(["success"=>false,"message"=>"Access denied"],403); $model=new Proposal(); $data=$model->getStudentProposals($teamId); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
