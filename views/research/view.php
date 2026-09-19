<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";


checkLogin();

checkRole(3); // Supervisor only



$research = new ResearchController();



if(!isset($_GET['id']))
{
    header("Location: manage.php");
    exit();
}



$id = $_GET['id'];



$opportunity = $research->opportunityDetails($id);



if(!$opportunity)
{
    echo "Research Opportunity Not Found";
    exit();
}


?>


<!DOCTYPE html>
<html>


<head>

<title>
View Research Opportunity
</title>

</head>



<body>


<h1>
Research Opportunity Details
</h1>



<a href="manage.php">
← Back to Opportunities
</a>


<br><br>



<table border="1" cellpadding="10">


<tr>

<th>
Title
</th>

<td>
<?= $opportunity['title']; ?>
</td>

</tr>



<tr>

<th>
Description
</th>

<td>
<?= $opportunity['description']; ?>
</td>

</tr>



<tr>

<th>
Supervisor
</th>

<td>
<?= $opportunity['supervisor_name']; ?>
</td>

</tr>



<tr>

<th>
Department
</th>

<td>
<?= $opportunity['department_name']; ?>
</td>

</tr>



<tr>

<th>
Required Skills
</th>

<td>
<?= $opportunity['required_skills']; ?>
</td>

</tr>



<tr>

<th>
Maximum Members
</th>

<td>
<?= $opportunity['max_members']; ?>
</td>

</tr>



<tr>

<th>
Deadline
</th>

<td>
<?= $opportunity['deadline']; ?>
</td>

</tr>



<tr>

<th>
Status
</th>

<td>
<?= $opportunity['status']; ?>
</td>

</tr>



<tr>

<th>
Posted Date
</th>

<td>
<?= $opportunity['posted_at']; ?>
</td>

</tr>



</table>



</body>


</html>