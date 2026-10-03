<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([2,3,4]); $id=apiInt($_GET['id']??null,'project ID'); $model=new ResearchProject(); $item=$model->getProjectById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Project not found"],404); $role=(int)$_SESSION['role_id']; $allowed=($role===4)||($role===3&&(int)$item['supervisor_id']===(int)$_SESSION['user_id']); if($role===2){$allowed=(bool)apiFindById($model->getStudentProjects((int)$_SESSION['user_id']),$id);} if(!$allowed) jsonResponse(["success"=>false,"message"=>"Access denied"],403); jsonResponse(["success"=>true,"data"=>$item]);
?>
