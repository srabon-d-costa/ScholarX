<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";

checkLogin();
checkRole(4);

$projectController = new ResearchProjectController();

$projects = $projectController->allProjects();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Monitor Research Projects - ScholarX</title>

</head>

<body>

<h1>Research Projects</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>

        <th>ID</th>

        <th>Project Title</th>

        <th>Description</th>

        <th>Supervisor ID</th>

        <th>Start Date</th>

        <th>End Date</th>

        <th>Status</th>

        <th>Progress</th>

    </tr>

    <?php if(count($projects) > 0): ?>

        <?php foreach($projects as $project): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($project['id']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['title']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['description']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['supervisor_id']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['start_date']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['end_date']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['status']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($project['progress']); ?>%
                </td>

            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>

            <td colspan="8">
                No research projects found.
            </td>

        </tr>

    <?php endif; ?>

</table>

</body>

</html>