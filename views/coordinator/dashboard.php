<?php


require_once "../../helpers/auth_check.php";

checkLogin();
checkRole(4);

?>

<!DOCTYPE html>
<html>

<head><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg"><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg">
    <title>Coordinator Dashboard - VarsityScholar</title>
    <link rel="stylesheet" href="/VarsityScholar/assets/css/style.css">

</head>

<body>

<h1>Welcome Coordinator</h1>

<p>
    VarsityScholar Department Research Coordination
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

    <li>
        <a href="../auth/logout.php">
            Logout
        </a>
    </li>

</ul>

    <script src="/VarsityScholar/assets/js/app.js"></script>

</body>

</html>