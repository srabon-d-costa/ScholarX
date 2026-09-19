<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";


checkLogin();

checkRole(3);



$project = new ResearchProjectController();



$projects = $project->projects(

    $_SESSION['user_id']

);


?>


<!DOCTYPE html>
<html>


<head>

<title>
Research Projects - ScholarX
</title>

</head>


<body>


<h1>
Research Projects
</h1>



<a href="../supervisor/dashboard.php">

← Back to Dashboard

</a>


<br><br>



<a href="create_project.php">

<button>
Create New Project
</button>

</a>


<br><br>




<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>


<th>
Title
</th>


<th>
Description
</th>


<th>
Start Date
</th>


<th>
End Date
</th>


<th>
Status
</th>


<th>
Progress
</th>


<th>
Action
</th>


</tr>




<?php foreach($projects as $projectData): ?>


<tr>


<td>

<?= $projectData['id']; ?>

</td>



<td>

<?= $projectData['title']; ?>

</td>



<td>

<?= $projectData['description']; ?>

</td>



<td>

<?= $projectData['start_date']; ?>

</td>



<td>

<?= $projectData['end_date']; ?>

</td>



<td>

<?= $projectData['status']; ?>

</td>



<td>

<?= $projectData['progress']; ?>%

</td>



<td>


<a href="project_details.php?id=<?= $projectData['id']; ?>">

View

</a>


</td>


</tr>



<?php endforeach; ?>



</table>



</body>


</html>