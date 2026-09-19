<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);


$team = new TeamController();


$teams = $team->teams(
    $_SESSION['user_id']
);

?>


<!DOCTYPE html>
<html>

<head>

<title>
Research Teams - ScholarX
</title>

</head>


<body>


<h1>
Research Teams
</h1>


<a href="../supervisor/dashboard.php">
← Back to Dashboard
</a>


<br><br>


<a href="create_team.php">

<button>
Create New Team
</button>

</a>


<br><br>



<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>


<th>
Team Name
</th>


<th>
Description
</th>


<th>
Created Date
</th>


<th>
Action
</th>

</tr>




<?php foreach($teams as $teamData): ?>


<tr>


<td>
<?= $teamData['id']; ?>
</td>


<td>
<?= $teamData['name']; ?>
</td>


<td>
<?= $teamData['description']; ?>
</td>


<td>
<?= $teamData['created_at']; ?>
</td>


<td>

<a href="team_details.php?id=<?= $teamData['id']; ?>">
Manage
</a>

</td>


</tr>


<?php endforeach; ?>


</table>


</body>

</html>