<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Feedback.php";
apiRequireMethod('GET'); apiRequireRole([3]); $model=new Feedback(); $data=$model->getSupervisorFeedback((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
