<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(2);

$announcement = new AnnouncementController();

$announcements = $announcement->studentAnnouncements(
    $_SESSION['user_id']
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Announcements - ScholarX</title>
</head>

<body>

<h1>Research Announcements</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<?php if (count($announcements) > 0): ?>

<table border="1" cellpadding="10">

    <tr>
        <th>Title</th>
        <th>Announcement</th>
        <th>Posted By</th>
        <th>Date</th>
    </tr>

    <?php foreach ($announcements as $item): ?>

    <tr>

        <td>
            <?= htmlspecialchars($item['title']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['content']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['creator_name']); ?>
        </td>

        <td>
            <?= htmlspecialchars($item['created_at']); ?>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    No announcements available.
</p>

<?php endif; ?>

</body>

</html>