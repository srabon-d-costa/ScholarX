<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/StudentController.php";


checkLogin();

checkRole(2);


$student = new StudentController();



if(!isset($_GET['id']))
{
    header("Location: opportunities.php");
    exit();
}



$id = $_GET['id'];



$opportunity = $student->opportunityDetails($id);



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
Research Opportunity Details - ScholarX
</title>

</head>


<body>


<h1>
Research Opportunity Details
</h1>


<a href="opportunities.php">
← Back to Opportunities
</a>


<br><br>


<table border="1" cellpadding="10">


<tr>

<th>Title</th>

<td>
<?= $opportunity['title']; ?>
</td>

</tr>


<tr>

<th>Description</th>

<td>
<?= $opportunity['description']; ?>
</td>

</tr>


<tr>

<th>Category</th>

<td>
<?= $opportunity['category_name']; ?>
</td>

</tr>


<tr>

<th>Supervisor</th>

<td>
<?= $opportunity['supervisor_name']; ?>
</td>

</tr>


<tr>

<th>Department</th>

<td>
<?= $opportunity['department_name']; ?>
</td>

</tr>


<tr>

<th>Required Skills</th>

<td>
<?= $opportunity['required_skills']; ?>
</td>

</tr>


<tr>

<th>Maximum Members</th>

<td>
<?= $opportunity['max_members']; ?>
</td>

</tr>


<tr>

<th>Deadline</th>

<td>
<?= $opportunity['deadline']; ?>
</td>

</tr>


<tr>

<th>Status</th>

<td>
<?= $opportunity['status']; ?>
</td>

</tr>


</table>


<br><br>


<a href="apply.php?id=<?= $opportunity['id']; ?>">

<button>
Apply For Project
</button>

</a>


</body>

</html>