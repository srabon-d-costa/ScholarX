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

    <title>
        Admin Dashboard - ScholarX
    </title>

</head>


<body>


<h1>
    ScholarX Admin Dashboard
</h1>


<p>
    Welcome,
    <?= htmlspecialchars($_SESSION['name']); ?>
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
            <?= htmlspecialchars($data['totalUsers']); ?>
        </td>

        <td>
            <?= htmlspecialchars($data['totalStudents']); ?>
        </td>

        <td>
            <?= htmlspecialchars($data['totalSupervisors']); ?>
        </td>

        <td>
            <?= htmlspecialchars($data['totalCoordinators']); ?>
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


    <li>
        <a href="activities.php">
            Monitor System Activities
        </a>
    </li>


    <li>
        <a href="research.php">
            Manage Research Opportunities
        </a>
    </li>


    <li>
        <a href="announcements.php">
            Manage Announcements
        </a>
    </li>

</ul>


</body>

</html>