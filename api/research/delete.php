<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Research.php";

apiRequireMethod('DELETE');
apiRequireRole([3]);
$id = apiInt($_GET['id'] ?? null, 'opportunity ID');

$research = new Research();
$item = $research->getOpportunityById($id);

if (!$item) {
    jsonResponse(["success" => false, "message" => "Research opportunity not found"], 404);
}

if ((int)$item['supervisor_id'] !== (int)$_SESSION['user_id']) {
    jsonResponse(["success" => false, "message" => "You are not allowed to delete this opportunity"], 403);
}

if (!$research->deleteOpportunity($id)) {
    jsonResponse(["success" => false, "message" => "Failed to delete research opportunity"], 500);
}

apiLog((int)$_SESSION['user_id'], "Deleted research opportunity ID: " . $id);
jsonResponse(["success" => true, "message" => "Research opportunity deleted successfully", "data" => ["id" => $id]]);
?>
