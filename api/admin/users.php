<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Admin.php";
apiRequireMethod('GET'); apiRequireRole([1]); $model=new Admin(); $keyword=isset($_GET['search'])?trim($_GET['search']):''; if($keyword!=='')$data=$model->searchUsers($keyword); elseif(isset($_GET['role_id']))$data=$model->getUsersByRole(apiInt($_GET['role_id'],'role ID')); else $data=$model->getAllUsers(); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
