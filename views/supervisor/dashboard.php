<?php

session_start();

require_once "../../helpers/auth_check.php";

checkLogin();

checkRole(3);

?>

<!DOCTYPE html>
<html>

<head>
<title>Supervisor Dashboard</title>
</head>

<body>

<h1>
Welcome Supervisor
</h1>

<p>
ScholarX Supervisor Research Management
</p>


<ul>

<li>Create Research Opportunities</li>
<li>Review Proposals</li>
<li>Manage Research Teams</li>
<li>Give Feedback</li>

</ul>


</body>

</html>