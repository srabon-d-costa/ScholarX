<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/DepartmentController.php";

checkLogin();
checkRole(4);

$department = new DepartmentController();

if(!isset($_GET['id']))
{
    header("Location: departments.php");
    exit();
}

$id = $_GET['id'];

$departmentData = $department->departmentDetails($id);

if(!$departmentData)
{
    echo "Department Not Found";
    exit();
}

$result = $department->deleteDepartment($id);

if($result)
{
    header("Location: departments.php");
    exit();
}

echo "Failed to delete department";

?>