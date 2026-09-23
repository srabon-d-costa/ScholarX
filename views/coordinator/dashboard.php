<?php

session_start();

require_once "../../helpers/auth_check.php";

checkLogin();
checkRole(4);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Coordinator Dashboard - ScholarX</title>
</head>

<body>

<h1>Welcome Coordinator</h1>

<p>
    ScholarX Department Research Coordination
</p>

<h2>Coordinator Functions</h2>

<ul>

    <li>
        <a href="projects.php">
            Monitor Research Projects
        </a>
    </li>

    <li>
        <a href="departments.php">
            Manage Departments
        </a>
    </li>

    <li>
        <a href="announcements.php">
            Publish Announcements
        </a>
    </li>

</ul>

</body>

</html>