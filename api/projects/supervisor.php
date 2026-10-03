<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([3]); $model=new ResearchProject(); $data=$model->getSupervisorProjects((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
