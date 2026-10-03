<?php

require_once "../../helpers/session.php";
require_once "../../helpers/json_response.php";
require_once "../../models/Research.php";
require_once "../../controllers/ActivityLogController.php";


// ==========================================================
// 1. REQUEST METHOD CHECK
// ==========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE')
{
    jsonResponse([
        "success" => false,
        "message" => "Only DELETE requests are allowed"
    ], 405);
}


// ==========================================================
// 2. AUTHENTICATION CHECK
// ==========================================================

if (!isset($_SESSION['user_id']))
{
    jsonResponse([
        "success" => false,
        "message" => "Authentication required"
    ], 401);
}


// ==========================================================
// 3. AUTHORIZATION CHECK
// Role 3 = Supervisor
// ==========================================================

if (
    !isset($_SESSION['role_id']) ||
    (int)$_SESSION['role_id'] !== 3
)
{
    jsonResponse([
        "success" => false,
        "message" => "Access denied"
    ], 403);
}


// ==========================================================
// 4. VALIDATE OPPORTUNITY ID
// Example:
// delete.php?id=5
// ==========================================================

if (
    !isset($_GET['id']) ||
    !filter_var($_GET['id'], FILTER_VALIDATE_INT)
)
{
    jsonResponse([
        "success" => false,
        "message" => "Valid opportunity ID is required"
    ], 400);
}


$id = (int)$_GET['id'];


// ==========================================================
// 5. GET OPPORTUNITY
// ==========================================================

$research = new Research();

$opportunity = $research->getOpportunityById($id);


// ==========================================================
// 6. CHECK IF OPPORTUNITY EXISTS
// ==========================================================

if (!$opportunity)
{
    jsonResponse([
        "success" => false,
        "message" => "Research opportunity not found"
    ], 404);
}


// ==========================================================
// 7. OWNERSHIP CHECK
// Supervisor can delete only their own opportunity
// ==========================================================

$supervisor_id = (int)$_SESSION['user_id'];


if (
    !isset($opportunity['supervisor_id']) ||
    (int)$opportunity['supervisor_id'] !== $supervisor_id
)
{
    jsonResponse([
        "success" => false,
        "message" => "You are not allowed to delete this opportunity"
    ], 403);
}


// ==========================================================
// 8. DELETE OPPORTUNITY
// ==========================================================

$result = $research->deleteOpportunity($id);


if (!$result)
{
    jsonResponse([
        "success" => false,
        "message" => "Failed to delete research opportunity"
    ], 500);
}


// ==========================================================
// 9. ACTIVITY LOG
// ==========================================================

$activityLog = new ActivityLogController();


$activityLog->log(
    $supervisor_id,
    "Deleted research opportunity ID: " . $id
);


// ==========================================================
// 10. SUCCESS RESPONSE
// ==========================================================

jsonResponse([
    "success" => true,
    "message" => "Research opportunity deleted successfully",
    "data" => [
        "id" => $id
    ]
], 200);

?>