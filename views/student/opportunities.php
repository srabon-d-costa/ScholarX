<?php

require_once "../../helpers/auth_check.php";
require_once "../../controllers/StudentController.php";


checkLogin();

checkRole(2);


$student = new StudentController();

$opportunities = $student->opportunities();

?>


<!DOCTYPE html>
<html>

<head><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg"><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg">

<title>
Research Opportunities - VarsityScholar
</title>

    <link rel="stylesheet" href="/VarsityScholar/assets/css/style.css">

</head>


<body>


<h1>
Available Research Opportunities
</h1>


<a href="dashboard.php">
← Back to Dashboard
</a>


<br><br>


<table border="1" cellpadding="10">


<tr>

<th>ID</th>

<th>Title</th>

<th>Category</th>

<th>Supervisor</th>

<th>Department</th>

<th>Skills</th>

<th>Status</th>

<th>Action</th>

</tr>



<?php foreach($opportunities as $opportunity): ?>


<tr>


<td>
<?= $opportunity['id']; ?>
</td>


<td>
<?= $opportunity['title']; ?>
</td>


<td>
<?= $opportunity['category_name']; ?>
</td>


<td>
<?= $opportunity['supervisor_name']; ?>
</td>


<td>
<?= $opportunity['department_name']; ?>
</td>


<td>
<?= $opportunity['required_skills']; ?>
</td>


<td>
<?= $opportunity['status']; ?>
</td>


<td>

<a href="view_opportunity.php?id=<?= $opportunity['id']; ?>">
View Details
</a>

</td>


</tr>


<?php endforeach; ?>


</table>


    <script src="/VarsityScholar/assets/js/app.js"></script>

</body>

</html>