<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/NotificationController.php";

checkLogin();

checkRole(3);


// Notification Controller
$notification = new NotificationController();


// Current supervisor ID
$user_id = $_SESSION['user_id'];


// Get unread notification count
$unreadCount = $notification->unreadCount($user_id);

?>


<!DOCTYPE html>
<html>

<head>

<title>
Supervisor Dashboard
</title>

</head>


<body>


<h1>
Welcome Supervisor
</h1>


<p>
ScholarX Supervisor Research Management
</p>


<h2>
Supervisor Functions
</h2>


<ul>


<li>

<a href="../research/create.php">
Create Research Opportunities
</a>

</li>


<li>

<a href="../research/manage.php">
Manage Research Opportunities
</a>

</li>


<li>

<a href="applications.php">
Review Student Applications
</a>

</li>


<li>

<a href="teams.php">
Manage Research Teams
</a>

</li>


<li>

<a href="feedback.php">
Give Feedback
</a>

</li>


<li>

<a href="projects.php">
Manage Research Projects
</a>

</li>


<li>

<a href="proposals.php">
Review Research Proposals
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