<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Proposal.php";
apiRequireMethod('PUT'); apiRequireRole([3]); $id=apiInt($_GET['id']??null,'proposal ID'); $data=apiBody(); apiRequired($data,['status']); $status=trim($data['status']); if(!in_array($status,['Approved','Rejected'],true)) jsonResponse(["success"=>false,"message"=>"Invalid proposal status"],400); $model=new Proposal(); $items=$model->getSupervisorProposals((int)$_SESSION['user_id']); if(!apiFindById($items,$id)) jsonResponse(["success"=>false,"message"=>"Proposal not found or access denied"],404); if(!$model->updateStatus($id,$status)) jsonResponse(["success"=>false,"message"=>"Failed to update proposal status"],500); apiLog((int)$_SESSION['user_id'],$status.' research proposal ID: '.$id); jsonResponse(["success"=>true,"message"=>"Proposal status updated","data"=>["id"=>$id,"status"=>$status]]);
?>
