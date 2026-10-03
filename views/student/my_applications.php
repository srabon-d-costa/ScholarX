<?php


require_once "../../helpers/auth_check.php";
require_once "../../controllers/ApplicationController.php";


checkLogin();

checkRole(2);



$application = new ApplicationController();



$applications = $application->myApplications(
    $_SESSION['user_id']
);


?>


<!DOCTYPE html>
<html>


<head><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg"><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg">

<title>
My Applications - VarsityScholar
</title>

    <link rel="stylesheet" href="/VarsityScholar/assets/css/style.css">

</head>


<body>


<h1>
My Research Applications
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
Research Project
</th>


<th>
Message
</th>


<th>
Status
</th>


<th>
Applied Date
</th>


</tr>




<?php foreach($applications as $app): ?>


<tr>


<td>
<?= $app['id']; ?>
</td>



<td>
<?= $app['title']; ?>
</td>



<td>
<?= $app['message']; ?>
</td>



<td>
<?= $app['status']; ?>
</td>



<td>
<?= $app['applied_at']; ?>
</td>


</tr>


<?php endforeach; ?>


</table>



    <script src="/VarsityScholar/assets/js/app.js"></script>

</body>


</html>