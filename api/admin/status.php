<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Admin.php";
apiRequireMethod('PUT'); apiRequireRole([1]); $id=apiInt($_GET['id']??null,'user ID'); $data=apiBody(); apiRequired($data,['status']); $status=trim($data['status']); if(!in_array($status,['Active','Inactive'],true))jsonResponse(["success"=>false,"message"=>"Invalid user status"],400); $model=new Admin(); if(!$model->getUserById($id))jsonResponse(["success"=>false,"message"=>"User not found"],404); if($id===(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"You cannot change your own status"],400); if(!$model->updateUserStatus($id,$status))jsonResponse(["success"=>false,"message"=>"Failed to update user status"],500); apiLog((int)$_SESSION['user_id'],'Changed user ID '.$id.' status to '.$status); jsonResponse(["success"=>true,"message"=>"User status updated","data"=>["id"=>$id,"status"=>$status]]);
?>
