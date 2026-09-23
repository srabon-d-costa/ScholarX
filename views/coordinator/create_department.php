<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/DepartmentController.php";

checkLogin();
checkRole(4);

$department = new DepartmentController();

$message = "";

if(isset($_POST['create']))
{
    $result = $department->createDepartment(
        $_POST['name'],
        $_POST['code'],
        $_POST['description']
    );

    if($result)
    {
        header("Location: departments.php");
        exit();
    }
    else
    {
        $message = "Failed to create department";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Department - ScholarX</title>

</head>

<body>

<h1>Create Department</h1>

<a href="departments.php">
    ← Back to Departments
</a>

<br><br>

<?php if($message != ""): ?>

<p>
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>

<form method="POST">

    <label>
        Department Name
    </label>

    <br>

    <input
        type="text"
        name="name"
        required
    >

    <br><br>

    <label>
        Department Code
    </label>

    <br>

    <input
        type="text"
        name="code"
        required
    >

    <br><br>

    <label>
        Description
    </label>

    <br>

    <textarea
        name="description"
        rows="5"
        cols="40"
        required
    ></textarea>

    <br><br>

    <button
        type="submit"
        name="create"
    >
        Create Department
    </button>

</form>

</body>

</html>