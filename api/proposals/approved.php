<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Proposal.php";
apiRequireMethod('GET'); apiRequireRole([3,4]); $model=new Proposal(); $data=$model->getApprovedProposals(); jsonResponse(["success"=>true,"count"=>count($data),"data"=>$data]);
?>
