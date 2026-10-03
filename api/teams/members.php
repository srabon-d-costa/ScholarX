<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('GET'); apiRequireRole([2,3]); $id=apiInt($_GET['team_id']??null,'team ID'); $model=new Team(); $team=$model->getTeamById($id); if(!$team)jsonResponse(["success"=>false,"message"=>"Team not found"],404); $role=(int)$_SESSION['role_id']; $allowed=($role===3&&(int)$team['created_by']===(int)$_SESSION['user_id']); if($role===2)$allowed=(bool)apiFindById($model->getStudentTeams((int)$_SESSION['user_id']),$id); if(!$allowed)jsonResponse(["success"=>false,"message"=>"Access denied"],403); $data=$model->getMembers($id); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
