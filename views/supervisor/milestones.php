<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/MilestoneController.php";
require_once "../../controllers/ResearchProjectController.php";


checkLogin();

checkRole(3);


$milestone = new MilestoneController();

$projectController = new ResearchProjectController();


if(!isset($_GET['project_id']))
{
    header("Location: projects.php");
    exit();
}


$project_id = $_GET['project_id'];


$project = $projectController->projectDetails($project_id);


if(!$project)
{
    echo "Research Project Not Found";
    exit();
}


$milestones = $milestone->milestones($project_id);

?>

<!DOCTYPE html>
<html>

<head>

<title>
Research Project Milestones - ScholarX
</title>

</head>


<body>


<h1>
Research Project Milestones
</h1>


<a href="project_details.php?id=<?= $project_id; ?>">

← Back to Project

</a>


<br><br>


<h2>

<?= htmlspecialchars($project['title']); ?>

</h2>


<p>

<?= htmlspecialchars($project['description']); ?>

</p>


<br>


<a href="create_milestone.php?project_id=<?= $project_id; ?>">

<button type="button">

Create New Milestone

</button>

</a>


<br><br>


<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>

<th>
Milestone
</th>

<th>
Description
</th>

<th>
Due Date
</th>

<th>
Status
</th>

<th>
Action
</th>

</tr>


<?php if(count($milestones) > 0): ?>


<?php foreach($milestones as $item): ?>


<tr>


<td>

<?= $item['id']; ?>

</td>


<td>

<?= htmlspecialchars($item['title']); ?>

</td>


<td>

<?= htmlspecialchars($item['description']); ?>

</td>


<td>

<?= htmlspecialchars($item['due_date']); ?>

</td>


<td>

<?= htmlspecialchars($item['status']); ?>

</td>


<td>

<a href="milestone_details.php?id=<?= $item['id']; ?>">

Manage

</a>

</td>


</tr>


<?php endforeach; ?>


<?php else: ?>


<tr>

<td colspan="6">

No milestones found.

</td>

</tr>


<?php endif; ?>


</table>


</body>

</html>