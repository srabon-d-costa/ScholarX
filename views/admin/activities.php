<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ActivityLogController.php";

checkLogin();

checkRole(1);


$activity = new ActivityLogController();

$activities = $activity->activities();

?>

<!DOCTYPE html>
<html>

<head>

<title>
System Activities - ScholarX
</title>

</head>


<body>


<h1>
System Activity Monitoring
</h1>


<a href="dashboard.php">
← Back to Dashboard
</a>


<br><br>


<h2>
Activity Logs
</h2>


<?php if (count($activities) > 0): ?>


<table border="1" cellpadding="10">

<tr>

<th>
ID
</th>

<th>
User
</th>

<th>
Email
</th>

<th>
Action
</th>

<th>
IP Address
</th>

<th>
Date
</th>

</tr>


<?php foreach ($activities as $item): ?>


<tr>

<td>
<?= htmlspecialchars($item['id']); ?>
</td>


<td>
<?= htmlspecialchars($item['user_name']); ?>
</td>


<td>
<?= htmlspecialchars($item['user_email']); ?>
</td>


<td>
<?= htmlspecialchars($item['action']); ?>
</td>


<td>
<?= htmlspecialchars($item['ip_address']); ?>
</td>


<td>
<?= htmlspecialchars($item['created_at']); ?>
</td>

</tr>


<?php endforeach; ?>


</table>


<?php else: ?>


<p>
No activity logs found.
</p>


<?php endif; ?>


</body>

</html>