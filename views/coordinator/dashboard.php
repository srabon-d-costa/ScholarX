<?php

session_start();

require_once "../../helpers/auth_check.php";

checkLogin();

checkRole(4);

?>

<!DOCTYPE html>
<html>

<head>
<title>Coordinator Dashboard</title>
</head>

<body>

<h1>
Welcome Coordinator
</h1>

<p>
ScholarX Department Research Coordination
</p>


<ul>

<li>Monitor Projects</li>
<li>Manage Departments</li>
<li>Publish Announcements</li>

</ul>


</body>

</html>