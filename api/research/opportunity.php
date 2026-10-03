<?php

require_once "../../models/Research.php";
require_once "../../helpers/json_response.php";

$research = new Research();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if($id === false || $id === null || $id <= 0)
{
    jsonResponse([
        "success" => false,
        "message" => "Valid opportunity ID is required"
    ], 400);
}

$opportunity = $research->getOpportunityById($id);

if(!$opportunity)
{
    jsonResponse([
        "success" => false,
        "message" => "Research opportunity not found"
    ], 404);
}

jsonResponse([
    "success" => true,
    "data" => $opportunity
]);

?>