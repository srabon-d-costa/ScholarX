<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";
require_once "../../controllers/MilestoneController.php";

checkLogin();
checkRole(2);

$projectController = new ResearchProjectController();
$milestoneController = new MilestoneController();

$student_id = $_SESSION['user_id'];

$projects = $projectController->studentProjects($student_id);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Research Progress - ScholarX</title>

</head>

<body>

<h1>My Research Progress</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<?php if (count($projects) > 0): ?>

    <?php foreach ($projects as $project): ?>

        <?php

        $project_id = $project['id'];

        $milestones = $milestoneController->milestones(
            $project_id
        );

        $progress = $projectController->calculateProgress(
            $project_id
        );

        ?>

        <h2>
            <?= htmlspecialchars($project['title']); ?>
        </h2>

        <p>
            <?= htmlspecialchars($project['description']); ?>
        </p>

        <table border="1" cellpadding="10">

            <tr>
                <th>Start Date</th>
                <td>
                    <?= htmlspecialchars($project['start_date']); ?>
                </td>
            </tr>

            <tr>
                <th>End Date</th>
                <td>
                    <?= htmlspecialchars($project['end_date']); ?>
                </td>
            </tr>

            <tr>
                <th>Project Status</th>
                <td>
                    <?= htmlspecialchars($project['status']); ?>
                </td>
            </tr>

            <tr>
                <th>Overall Progress</th>
                <td>
                    <strong><?= $progress; ?>%</strong>
                </td>
            </tr>

        </table>

        <h3>Project Milestones</h3>

        <?php if (count($milestones) > 0): ?>

            <table border="1" cellpadding="10">

                <tr>
                    <th>ID</th>
                    <th>Milestone</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($milestones as $milestone): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($milestone['id']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($milestone['title']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($milestone['description']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($milestone['due_date']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($milestone['status']); ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p>
                No milestones have been created for this project yet.
            </p>

        <?php endif; ?>

        <br>

        <hr>

        <br>

    <?php endforeach; ?>

<?php else: ?>

    <p>
        You are not currently assigned to any research project.
    </p>

<?php endif; ?>

</body>

</html>