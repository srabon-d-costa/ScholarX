<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);



$team = new TeamController();



if(!isset($_GET['team_id']))
{
    header("Location: teams.php");
    exit();
}



$team_id = $_GET['team_id'];



$students = $team->students();



$message = "";



if(isset($_POST['add']))
{

    $result = $team->addMember(

        $team_id,

        $_POST['user_id']

    );


    if($result)
    {
        $message = "Student Added To Team Successfully";
    }
    else
    {
        $message = "Student Already Added To This Team";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Add Team Member - ScholarX
</title>

</head>


<body>


<h1>
Add Team Member
</h1>


<a href="team_details.php?id=<?= $team_id; ?>">
← Back to Team
</a>


<br><br>


<p>

<?= $message; ?>

</p>



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



<?php foreach($students as $student): ?>


<tr>


<td>
<?= $student['id']; ?>
</td>


<td>
<?= $student['name']; ?>
</td>


<td>
<?= $student['email']; ?>
</td>


<td>


<form method="POST">


<input

type="hidden"

name="user_id"

value="<?= $student['id']; ?>">



<button name="add">

Add

</button>


</form>


</td>


</tr>


<?php endforeach; ?>


</table>


</body>


</html>