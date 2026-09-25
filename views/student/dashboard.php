<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/NotificationController.php";

checkLogin();

checkRole(2);


// Notification Controller
$notification = new NotificationController();


// Current student ID
$user_id = $_SESSION['user_id'];


// Get unread notification count
$unreadCount = $notification->unreadCount($user_id);

?>


<!DOCTYPE html>
<html>


<head>

    <title>
        Student Dashboard - ScholarX
    </title>

</head>


<body>


<h1>
    Welcome Student
</h1>


<p>
    ScholarX Student Research Portal
</p>


<h2>
    Student Functions
</h2>


<ul>


    <li>

        <a href="opportunities.php">
            Browse Research Opportunities
        </a>

    </li>


    <li>

        <a href="my_applications.php">
            Apply for Projects
        </a>

    </li>


    <li>

        <a href="teams.php">
            Manage Research Team
        </a>

    </li>


    <li>

        <a href="milestones.php">
            Track Milestones
        </a>

    </li>


    <li>

        <a href="feedbacks.php">
            View Feedback
        </a>

    </li>


    <li>

        <a href="create_proposal.php">
            Submit Research Proposal
        </a>

    </li>


    <li>

        <a href="announcements.php">
            View Announcements
        </a>

    </li>


    <li>

        <a href="notifications.php">

            🔔 Notifications

            <?php if($unreadCount > 0): ?>

                (<?= htmlspecialchars($unreadCount); ?>)

            <?php endif; ?>

        </a>

    </li>


</ul>


</body>


</html>