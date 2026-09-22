<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/FeedbackController.php";

checkLogin();
checkRole(2);

$feedback = new FeedbackController();

$feedbacks = $feedback->studentFeedback(
    $_SESSION['user_id']
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Feedback - ScholarX</title>

</head>

<body>

<h1>My Research Feedback</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<?php if (count($feedbacks) > 0): ?>

<table border="1" cellpadding="10">

    <tr>

        <th>ID</th>
        <th>Project ID</th>
        <th>Supervisor</th>
        <th>Feedback</th>
        <th>Rating</th>
        <th>Date</th>

    </tr>

    <?php foreach ($feedbacks as $item): ?>

    <tr>

        <td>
            <?= htmlspecialchars($item['id']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['project_id']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['supervisor_name']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['message']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['rating']); ?>/5
        </td>

        <td>
            <?= htmlspecialchars($item['created_at']); ?>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    No Feedback Available
</p>

<?php endif; ?>

</body>

</html>