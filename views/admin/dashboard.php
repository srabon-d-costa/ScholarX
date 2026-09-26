<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);



$adminController = new AdminController();

$data = $adminController->dashboard();

?>


<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard - ScholarX</title>

</head>


<body>


<h1>
ScholarX Admin Dashboard
</h1>


<p>
Welcome, 
<?= $_SESSION['name']; ?>
</p>



<hr>


<h2>
System Overview
</h2>



<table border="1" cellpadding="15">


<tr>

<th>
Total Users
</th>

<th>
Students
</th>

<th>
Supervisors
</th>

<th>
Coordinators
</th>

</tr>



<tr>

<td>
<?= $data['totalUsers']; ?>
</td>


<td>
<?= $data['totalStudents']; ?>
</td>


<td>
<?= $data['totalSupervisors']; ?>
</td>


<td>
<?= $data['totalCoordinators']; ?>
</td>


</tr>


</table>



<br><br>



<h2>
Admin Actions
</h2>


<ul>

<li>
<a href="users.php">
Manage Users
</a>
</li>


<a href="activities.php">
    Monitor System Activities
</a>


<li>
Manage Research Opportunities
</li>


<li>
Manage Announcements
</li>


<li>
View Activity Logs
</li>


</ul>



</body>

</html>