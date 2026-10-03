<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Research.php";

apiRequireMethod('PUT');
apiRequireRole([3]);
$id = apiInt($_GET['id'] ?? null, 'opportunity ID');
$data = apiBody();
apiRequired($data, ["title", "description", "category_id", "department_id", "required_skills", "max_members", "deadline", "status"]);

$research = new Research();
$item = $research->getOpportunityById($id);

if (!$item) {
    jsonResponse(["success" => false, "message" => "Research opportunity not found"], 404);
}

if ((int)$item['supervisor_id'] !== (int)$_SESSION['user_id']) {
    jsonResponse(["success" => false, "message" => "You are not allowed to update this opportunity"], 403);
}

$title = trim($data['title']);
$description = trim($data['description']);
$categoryId = apiInt($data['category_id'], 'category ID');
$departmentId = apiInt($data['department_id'], 'department ID');
$skills = trim($data['required_skills']);
$maxMembers = apiInt($data['max_members'], 'max_members');
$deadline = apiDate($data['deadline'], 'Deadline');
$status = trim($data['status']);

if ($title === '' || $description === '' || $skills === '') {
    jsonResponse(["success" => false, "message" => "Title, description and required skills cannot be empty"], 400);
}

if (!in_array($status, ['Open', 'Closed'], true)) {
    jsonResponse(["success" => false, "message" => "Invalid status"], 400);
}

$result = $research->updateOpportunity($id, $title, $description, $categoryId, $departmentId, $skills, $maxMembers, $deadline, $status);

if (!$result) {
    jsonResponse(["success" => false, "message" => "Failed to update research opportunity"], 500);
}

apiLog((int)$_SESSION['user_id'], "Updated research opportunity ID: " . $id);
jsonResponse(["success" => true, "message" => "Research opportunity updated successfully", "data" => ["id" => $id]]);
?>
