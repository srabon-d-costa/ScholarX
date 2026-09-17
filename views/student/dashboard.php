<?php

session_start();

require_once "../../helpers/auth_check.php";

checkLogin();

checkRole(2);

?>

<!DOCTYPE html>
<html>

<head>
<title>Student Dashboard</title>
</head>

<body>

<h1>
Welcome Student
</h1>

<p>
ScholarX Student Research Portal
</p>


<ul>

<li>Browse Research Opportunities</li>
<li>Apply for Projects</li>
<li>Manage Research Team</li>
<li>Track Milestones</li>

</ul>


</body>

</html>