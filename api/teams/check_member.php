<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Team.php";
apiRequireMethod('GET'); apiRequireAuth(); $teamId=apiInt($_GET['team_id']??null,'team ID'); $userId=apiInt($_GET['user_id']??null,'user ID'); $model=new Team(); $role=(int)$_SESSION['role_id']; $team=$model->getTeamById($teamId); if(!$team)jsonResponse(["success"=>false,"message"=>"Team not found"],404); if($role===3 && (int)$team['created_by']!==(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"Access denied"],403); if($role===2 && (int)$userId!==(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"Access denied"],403); $data=$model->checkMember($teamId,$userId); jsonResponse(["success"=>true,"member"=>(bool)$data,"data"=>$data]);
?>
