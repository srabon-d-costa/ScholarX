<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Admin.php";
apiRequireMethod('GET'); apiRequireRole([1]); $model=new Admin(); jsonResponse(["success"=>true,"data"=>["totalUsers"=>$model->countUsers(),"totalStudents"=>$model->countUsersByRole(2),"totalSupervisors"=>$model->countUsersByRole(3),"totalCoordinators"=>$model->countUsersByRole(4)]]);
?>
