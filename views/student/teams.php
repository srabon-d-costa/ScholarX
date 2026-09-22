<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";

checkLogin();
checkRole(2);

$teamController = new TeamController();

$student_id = $_SESSION['user_id'];

$teams = $teamController->studentTeams($student_id);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Research Teams - ScholarX</title>

</head>

<body>

<h1>My Research Teams</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<?php if (count($teams) > 0): ?>

    <?php foreach ($teams as $team): ?>

        <h2>
            <?= htmlspecialchars($team['name']); ?>
        </h2>

        <table border="1" cellpadding="10">

            <tr>
                <th>Team Name</th>
                <td>
                    <?= htmlspecialchars($team['name']); ?>
                </td>
            </tr>

            <tr>
                <th>Description</th>
                <td>
                    <?= htmlspecialchars($team['description']); ?>
                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>
                    <?= htmlspecialchars($team['created_at']); ?>
                </td>
            </tr>

        </table>

        <h3>Team Members</h3>

        <?php

        $members = $teamController->members(
            $team['id']
        );

        ?>

        <?php if (count($members) > 0): ?>

            <table border="1" cellpadding="10">

                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                </tr>

                <?php foreach ($members as $member): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($member['id']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($member['student_name']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($member['email']); ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p>
                No members found.
            </p>

        <?php endif; ?>

        <br>
        <hr>
        <br>

    <?php endforeach; ?>

<?php else: ?>

    <p>
        You are not currently assigned to any research team.
    </p>

<?php endif; ?>

</body>

</html>