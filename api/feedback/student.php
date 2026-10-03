<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Feedback.php";
apiRequireMethod('GET'); apiRequireRole([2]); $model=new Feedback(); $data=$model->getStudentFeedback((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
