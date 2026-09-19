<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);



$team = new TeamController();



if(!isset($_GET['id']))
{
    header("Location: teams.php");
    exit();
}



$id = $_GET['id'];



$teamData = $team->teamDetails($id);



if(!$teamData)
{
    echo "Team Not Found";
    exit();
}



$members = $team->members($id);


?>


<!DOCTYPE html>
<html>


<head>

<title>
Team Details - ScholarX
</title>

</head>


<body>


<h1>
Research Team Details
</h1>


<a href="teams.php">
← Back to Teams
</a>


<br><br>



<table border="1" cellpadding="10">


<tr>

<th>
Team Name
</th>

<td>
<?= $teamData['name']; ?>
</td>

</tr>



<tr>

<th>
Description
</th>

<td>
<?= $teamData['description']; ?>
</td>

</tr>



<tr>

<th>
Created Date
</th>

<td>
<?= $teamData['created_at']; ?>
</td>

</tr>


</table>



<br><br>



<h2>
Team Members
</h2>



<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>


<th>
Student Name
</th>


<th>
Email
</th>


<th>
Action
</th>


</tr>




<?php foreach($members as $member): ?>


<tr>


<td>
<?= $member['id']; ?>
</td>



<td>
<?= $member['student_name']; ?>
</td>



<td>
<?= $member['email']; ?>
</td>



<td>


<a href="remove_member.php?id=<?= $member['id']; ?>&team_id=<?= $id; ?>"
onclick="return confirm('Remove this student from team?');">

Remove

</a>


</td>


</tr>



<?php endforeach; ?>


</table>




<br>



<a href="add_member.php?team_id=<?= $id; ?>">

<button>

Add Member

</button>

</a>




</body>


</html>