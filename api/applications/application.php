<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
require_once __DIR__ . "/../../models/Research.php";
apiRequireMethod('GET'); apiRequireRole([2,3]); $id=apiInt($_GET['id']??null,'application ID'); $model=new Application(); $item=$model->getApplicationById($id); if(!$item) jsonResponse(["success"=>false,"message"=>"Application not found"],404);
$research=new Research(); $op=$research->getOpportunityById((int)$item['opportunity_id']); $role=(int)$_SESSION['role_id'];
if($role===2 && (int)$item['student_id']!==(int)$_SESSION['user_id']) jsonResponse(["success"=>false,"message"=>"Access denied"],403);
if($role===3 && (!$op || (int)$op['supervisor_id']!==(int)$_SESSION['user_id'])) jsonResponse(["success"=>false,"message"=>"Access denied"],403);
jsonResponse(["success"=>true,"data"=>$item]);
?>
