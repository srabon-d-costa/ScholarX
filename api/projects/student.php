<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([2]); $model=new ResearchProject(); $data=$model->getStudentProjects((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
