<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ApplicationController.php";


checkLogin();

checkRole(3); // Supervisor only



$application = new ApplicationController();



$applications = $application->applications(
    $_SESSION['user_id']
);



?>


<!DOCTYPE html>
<html>


<head>

<title>
Student Applications - ScholarX
</title>

</head>


<body>


<h1>
Student Research Applications
</h1>


<a href="dashboard.php">
← Back to Dashboard
</a>


<br><br>



<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>


<th>
Student Name
</th>


<th>
Research Title
</th>


<th>
Message
</th>


<th>
Status
</th>


<th>
Action
</th>


</tr>




<?php foreach($applications as $app): ?>


<tr>


<td>
<?= $app['id']; ?>
</td>


<td>
<?= $app['student_name']; ?>
</td>


<td>
<?= $app['research_title']; ?>
</td>


<td>
<?= $app['message']; ?>
</td>


<td>
<?= $app['status']; ?>
</td>



<td>


<?php if($app['status'] == "Pending"): ?>


<a href="change_application_status.php?id=<?= $app['id']; ?>&status=Accepted">

Accept

</a>


|

<a href="change_application_status.php?id=<?= $app['id']; ?>&status=Rejected">

Reject

</a>


<?php else: ?>


Completed

<?php endif; ?>


</td>


</tr>


<?php endforeach; ?>



</table>



</body>


</html>