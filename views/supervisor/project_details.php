<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";

checkLogin();
checkRole(3);

$project = new ResearchProjectController();

if (!isset($_GET['id'])) {
    header("Location: projects.php");
    exit();
}

$id = $_GET['id'];

$projectData = $project->projectDetails($id);

if (!$projectData) {
    echo "Project Not Found";
    exit();
}

$message = "";

// Update project status
if (isset($_POST['update'])) {

    $statusResult = $project->updateStatus(
        $id,
        $_POST['status']
    );

    if ($statusResult) {
        $message = "Project Status Updated Successfully";
        $projectData = $project->projectDetails($id);
    } else {
        $message = "Update Failed";
    }
}

// Calculate project progress automatically
$calculatedProgress = $project->calculateProgress($id);

// Synchronize calculated progress with database
if ($projectData['progress'] != $calculatedProgress) {

    $project->updateProgress(
        $id,
        $calculatedProgress
    );

    $projectData = $project->projectDetails($id);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Project Details - ScholarX</title>

</head>

<body>

<h1>Research Project Details</h1>

<a href="projects.php">
    ← Back to Projects
</a>

<br><br>

<?php if ($message != ""): ?>

<p>
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>

<table border="1" cellpadding="10">

    <tr>
        <th>Project Title</th>
        <td>
            <?= htmlspecialchars($projectData['title']); ?>
        </td>
    </tr>

    <tr>
        <th>Description</th>
        <td>
            <?= htmlspecialchars($projectData['description']); ?>
        </td>
    </tr>

    <tr>
        <th>Start Date</th>
        <td>
            <?= htmlspecialchars($projectData['start_date']); ?>
        </td>
    </tr>

    <tr>
        <th>End Date</th>
        <td>
            <?= htmlspecialchars($projectData['end_date']); ?>
        </td>
    </tr>

    <tr>
        <th>Current Status</th>
        <td>
            <?= htmlspecialchars($projectData['status']); ?>
        </td>
    </tr>

    <tr>
        <th>Current Progress</th>
        <td>
            <?= htmlspecialchars($calculatedProgress); ?>%
        </td>
    </tr>

</table>

<h2>Update Project Status</h2>

<form method="POST">

    <label>Status</label>

    <br>

    <select name="status" required>

        <option
            value="Approved"
            <?= ($projectData['status'] == "Approved") ? "selected" : ""; ?>
        >
            Approved
        </option>

        <option
            value="Active"
            <?= ($projectData['status'] == "Active") ? "selected" : ""; ?>
        >
            Active
        </option>

        <option
            value="On Hold"
            <?= ($projectData['status'] == "On Hold") ? "selected" : ""; ?>
        >
            On Hold
        </option>

        <option
            value="Completed"
            <?= ($projectData['status'] == "Completed") ? "selected" : ""; ?>
        >
            Completed
        </option>

    </select>

    <br><br>

    <button type="submit" name="update">
        Update Project Status
    </button>

</form>

<h2>Project Milestones</h2>

<a href="milestones.php?project_id=<?= $id; ?>">
    <button type="button">
        Manage Milestones
    </button>
</a>

</body>

</html>