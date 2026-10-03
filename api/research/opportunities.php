<?php

require_once "../../models/Research.php";
require_once "../../helpers/json_response.php";

$research = new Research();

$opportunities = $research->getAllOpportunities();

jsonResponse([
    "success" => true,
    "count" => count($opportunities),
    "data" => $opportunities
]);

?>