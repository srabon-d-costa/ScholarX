<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('DELETE'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'project ID'); $model=new ResearchProject(); $project=$model->getProjectById($id); if(!$project)jsonResponse(["success"=>false,"message"=>"Project not found"],404); if((int)$project['supervisor_id']!==(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"Access denied"],403); if(!$model->deleteProject($id))jsonResponse(["success"=>false,"message"=>"Failed to delete project"],500); apiLog((int)$_SESSION['user_id'],'Deleted research project ID: '.$id); jsonResponse(["success"=>true,"message"=>"Research project deleted successfully","data"=>["id"=>$id]]);
?>
