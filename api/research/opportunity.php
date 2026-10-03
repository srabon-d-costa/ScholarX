<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Research.php";

apiRequireMethod('GET');
apiRequireAuth();

$id = apiInt($_GET['id'] ?? null, 'opportunity ID');
$research = new Research();
$item = $research->getOpportunityById($id);

if (!$item) {
    jsonResponse(["success" => false, "message" => "Research opportunity not found"], 404);
}

jsonResponse(["success" => true, "data" => $item]);
?>
