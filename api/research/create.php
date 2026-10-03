<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Research.php";

apiRequireMethod('POST');
apiRequireRole([3]);
$data = apiBody();
apiRequired($data, ["title", "description", "category_id", "department_id", "required_skills", "max_members", "deadline"]);

$title = trim($data['title']);
$description = trim($data['description']);
$categoryId = apiInt($data['category_id'], 'category ID');
$departmentId = apiInt($data['department_id'], 'department ID');
$skills = trim($data['required_skills']);
$maxMembers = apiInt($data['max_members'], 'max_members');
$deadline = apiDate($data['deadline'], 'Deadline');

if ($title === '' || $description === '' || $skills === '') {
    jsonResponse(["success" => false, "message" => "Title, description and required skills cannot be empty"], 400);
}

$research = new Research();
$result = $research->createOpportunity($title, $description, $categoryId, (int)$_SESSION['user_id'], $departmentId, $skills, $maxMembers, $deadline);

if (!$result) {
    jsonResponse(["success" => false, "message" => "Failed to create research opportunity"], 500);
}

apiLog((int)$_SESSION['user_id'], "Created research opportunity: " . $title);
jsonResponse(["success" => true, "message" => "Research opportunity created successfully"], 201);
?>
