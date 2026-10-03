<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Admin.php";
apiRequireMethod('DELETE'); apiRequireRole([1]); $id=apiInt($_GET['id']??null,'user ID'); if($id===(int)$_SESSION['user_id'])jsonResponse(["success"=>false,"message"=>"You cannot delete your own account"],400); $model=new Admin(); if(!$model->getUserById($id))jsonResponse(["success"=>false,"message"=>"User not found"],404); if(!$model->deleteUser($id))jsonResponse(["success"=>false,"message"=>"Failed to delete user"],500); apiLog((int)$_SESSION['user_id'],'Deleted user ID: '.$id); jsonResponse(["success"=>true,"message"=>"User deleted successfully","data"=>["id"=>$id]]);
?>
