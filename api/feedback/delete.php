<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Feedback.php";
apiRequireMethod('DELETE'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'feedback ID');
// The current model only deletes by ID. Verify ownership by loading the supervisor's own feedback first.
$model=new Feedback(); $items=$model->getSupervisorFeedback((int)$_SESSION['user_id']); if(!apiFindById($items,$id)) jsonResponse(["success"=>false,"message"=>"Feedback not found or access denied"],404);
if(!$model->deleteFeedback($id)) jsonResponse(["success"=>false,"message"=>"Failed to delete feedback"],500); apiLog((int)$_SESSION['user_id'],'Deleted feedback ID: '.$id); jsonResponse(["success"=>true,"message"=>"Feedback deleted successfully","data"=>["id"=>$id]]);
?>
