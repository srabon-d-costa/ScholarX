<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/ResearchProject.php";
apiRequireMethod('GET'); apiRequireRole([1,4]); $model=new ResearchProject(); $data=$model->getAllProjects(); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
