<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";


checkLogin();

checkRole(3);



$research = new ResearchController();



$opportunities = $research->opportunities();


?>


<!DOCTYPE html>
<html>

<head>

<title>
Manage Research Opportunities
</title>

</head>


<body>


<h1>
Manage Research Opportunities
</h1>


<a href="../supervisor/dashboard.php">
← Back to Dashboard
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
Supervisor
</th>


<th>
Department
</th>


<th>
Status
</th>


<th>
Action
</th>


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
<?= $opportunity['supervisor_name']; ?>
</td>



<td>
<?= $opportunity['department_name']; ?>
</td>



<td>
<?= $opportunity['status']; ?>
</td>




<td>


<a href="view.php?id=<?= $opportunity['id']; ?>">
View
</a>


|

<a href="edit.php?id=<?= $opportunity['id']; ?>">
Edit
</a>


|

<a 
href="delete.php?id=<?= $opportunity['id']; ?>"
onclick="return confirm('Delete this opportunity?');">

Delete

</a>


</td>



</tr>


<?php endforeach; ?>


</table>



</body>

</html>