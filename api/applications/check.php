<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Application.php";
apiRequireMethod('GET'); apiRequireRole([2]); $opportunityId=apiInt($_GET['opportunity_id']??null,'opportunity ID'); $model=new Application(); $data=$model->checkApplication($opportunityId,(int)$_SESSION['user_id']);
jsonResponse(["success"=>true,"applied"=>(bool)$data,"data"=>$data]);
?>
