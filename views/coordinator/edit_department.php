<?php


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

$message = "";

if(isset($_POST['update']))
{
    $result = $department->updateDepartment(
        $id,
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
        $message = "Update Failed";
    }
}

?>

<!DOCTYPE html>
<html>

<head><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg"><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg">

    <title>Edit Department - VarsityScholar</title>

    <link rel="stylesheet" href="/VarsityScholar/assets/css/style.css">

</head>

<body>

<h1>Edit Department</h1>

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
        value="<?= htmlspecialchars($departmentData['name']); ?>"
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
        value="<?= htmlspecialchars($departmentData['code']); ?>"
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
    ><?= htmlspecialchars($departmentData['description']); ?></textarea>

    <br><br>

    <button
        type="submit"
        name="update"
    >
        Update Department
    </button>

</form>

    <script src="/VarsityScholar/assets/js/app.js"></script>

</body>

</html>