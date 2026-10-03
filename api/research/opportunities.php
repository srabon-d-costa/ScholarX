<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Research.php";

apiRequireMethod('GET');
apiRequireAuth();

$research = new Research();
$data = $research->getAllOpportunities();

jsonResponse([
    "success" => true,
    "count" => count($data),
    "data" => $data
]);
?>
