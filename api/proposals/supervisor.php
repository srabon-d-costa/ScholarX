<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Proposal.php";
apiRequireMethod('GET'); apiRequireRole([3]); $model=new Proposal(); $data=$model->getSupervisorProposals((int)$_SESSION['user_id']); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
