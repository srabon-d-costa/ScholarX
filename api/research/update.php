<?php

require_once "../../helpers/session.php";
require_once "../../helpers/json_response.php";
require_once "../../models/Research.php";
require_once "../../controllers/ActivityLogController.php";


// ==========================================================
// 1. REQUEST METHOD CHECK
// ==========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'PUT')
{
    jsonResponse([
        "success" => false,
        "message" => "Only PUT requests are allowed"
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
// 4. GET OPPORTUNITY ID
// Example:
// update.php?id=5
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
// 5. FIND EXISTING OPPORTUNITY
// ==========================================================

$research = new Research();

$opportunity = $research->getOpportunityById($id);


if (!$opportunity)
{
    jsonResponse([
        "success" => false,
        "message" => "Research opportunity not found"
    ], 404);
}


// ==========================================================
// 6. OWNERSHIP CHECK
// Supervisor can update only their own opportunity
// ==========================================================

$supervisor_id = (int)$_SESSION['user_id'];

if (
    !isset($opportunity['supervisor_id']) ||
    (int)$opportunity['supervisor_id'] !== $supervisor_id
)
{
    jsonResponse([
        "success" => false,
        "message" => "You are not allowed to update this opportunity"
    ], 403);
}


// ==========================================================
// 7. READ JSON BODY
// ==========================================================

$input = json_decode(
    file_get_contents("php://input"),
    true
);


// ==========================================================
// 8. VALIDATE JSON
// ==========================================================

if (!is_array($input))
{
    jsonResponse([
        "success" => false,
        "message" => "Invalid JSON data"
    ], 400);
}


// ==========================================================
// 9. REQUIRED FIELDS
// ==========================================================

$requiredFields = [
    "title",
    "description",
    "category_id",
    "department_id",
    "required_skills",
    "max_members",
    "deadline",
    "status"
];


foreach ($requiredFields as $field)
{
    if (
        !isset($input[$field]) ||
        trim((string)$input[$field]) === ''
    )
    {
        jsonResponse([
            "success" => false,
            "message" => "Missing required field: " . $field
        ], 400);
    }
}


// ==========================================================
// 10. GET INPUT DATA
// ==========================================================

$title = trim($input['title']);

$description = trim($input['description']);

$category_id = filter_var(
    $input['category_id'],
    FILTER_VALIDATE_INT
);

$department_id = filter_var(
    $input['department_id'],
    FILTER_VALIDATE_INT
);

$required_skills = trim(
    $input['required_skills']
);

$max_members = filter_var(
    $input['max_members'],
    FILTER_VALIDATE_INT
);

$deadline = trim(
    $input['deadline']
);

$status = trim(
    $input['status']
);


// ==========================================================
// 11. VALIDATE TITLE
// ==========================================================

if ($title === '')
{
    jsonResponse([
        "success" => false,
        "message" => "Title cannot be empty"
    ], 400);
}


// ==========================================================
// 12. VALIDATE CATEGORY
// ==========================================================

if (
    $category_id === false ||
    $category_id <= 0
)
{
    jsonResponse([
        "success" => false,
        "message" => "Invalid category ID"
    ], 400);
}


// ==========================================================
// 13. VALIDATE DEPARTMENT
// ==========================================================

if (
    $department_id === false ||
    $department_id <= 0
)
{
    jsonResponse([
        "success" => false,
        "message" => "Invalid department ID"
    ], 400);
}


// ==========================================================
// 14. VALIDATE MAX MEMBERS
// ==========================================================

if (
    $max_members === false ||
    $max_members <= 0
)
{
    jsonResponse([
        "success" => false,
        "message" => "Maximum members must be greater than 0"
    ], 400);
}


// ==========================================================
// 15. VALIDATE DEADLINE
// Format: YYYY-MM-DD
// ==========================================================

$date = DateTime::createFromFormat(
    'Y-m-d',
    $deadline
);


if (
    !$date ||
    $date->format('Y-m-d') !== $deadline
)
{
    jsonResponse([
        "success" => false,
        "message" => "Deadline must be in YYYY-MM-DD format"
    ], 400);
}


// ==========================================================
// 16. VALIDATE STATUS
// ==========================================================

$allowedStatuses = [
    "Open",
    "Closed"
];


if (!in_array($status, $allowedStatuses, true))
{
    jsonResponse([
        "success" => false,
        "message" => "Invalid status"
    ], 400);
}


// ==========================================================
// 17. UPDATE OPPORTUNITY
// ==========================================================

$result = $research->updateOpportunity(
    $id,
    $title,
    $description,
    $category_id,
    $department_id,
    $required_skills,
    $max_members,
    $deadline,
    $status
);


if (!$result)
{
    jsonResponse([
        "success" => false,
        "message" => "Failed to update research opportunity"
    ], 500);
}


// ==========================================================
// 18. ACTIVITY LOG
// ==========================================================

$activityLog = new ActivityLogController();

$activityLog->log(
    $supervisor_id,
    "Updated research opportunity ID: " . $id
);


// ==========================================================
// 19. SUCCESS RESPONSE
// ==========================================================

jsonResponse([
    "success" => true,
    "message" => "Research opportunity updated successfully",
    "data" => [
        "id" => $id
    ]
], 200);

?>