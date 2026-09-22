<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";

checkLogin();
checkRole(3);

$teamController = new TeamController();

$supervisor_id = $_SESSION['user_id'];

$teams = $teamController->teams($supervisor_id);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Research Teams - ScholarX</title>
</head>

<body>

<h1>Research Teams</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<a href="create_team.php">
    <button type="button">
        Create New Team
    </button>
</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Team Name</th>
    <th>Description</th>
    <th>Created At</th>
    <th>Action</th>
</tr>

<?php if (count($teams) > 0): ?>

    <?php foreach ($teams as $team): ?>

        <tr>

            <td>
                <?= htmlspecialchars($team['id']); ?>
            </td>

            <td>
                <?= htmlspecialchars($team['name']); ?>
            </td>

            <td>
                <?= htmlspecialchars($team['description']); ?>
            </td>

            <td>
                <?= htmlspecialchars($team['created_at']); ?>
            </td>

            <td>
                <a href="team_details.php?id=<?= $team['id']; ?>">
                    Manage
                </a>
            </td>

        </tr>

    <?php endforeach; ?>

<?php else: ?>

    <tr>
        <td colspan="5">
            No research teams found.
        </td>
    </tr>

<?php endif; ?>

</table>

</body>

</html>