<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('DELETE'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'team member ID'); $teamId=apiInt($_GET['team_id']??null,'team ID'); $model=new Team(); $team=$model->getTeamById($teamId); if(!$team)jsonResponse(["success"=>false,"message"=>"Team not found"],404); if((int)$team['created_by']!==(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"Access denied"],403); $member=apiFindById($model->getMembers($teamId),$id); if(!$member)jsonResponse(["success"=>false,"message"=>"Team member not found"],404); if(!$model->removeMember($id))jsonResponse(["success"=>false,"message"=>"Failed to remove team member"],500); apiLog((int)$_SESSION['user_id'],'Removed team member record ID: '.$id); jsonResponse(["success"=>true,"message"=>"Team member removed successfully","data"=>["id"=>$id]]);
?>
