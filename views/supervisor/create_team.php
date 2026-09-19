<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);



$team = new TeamController();


$message = "";



if(isset($_POST['create']))
{

    $result = $team->createTeam(

        $_POST['name'],

        $_POST['description'],

        $_SESSION['user_id']

    );


    if($result)
    {
        $message = "Team Created Successfully";
    }
    else
    {
        $message = "Failed To Create Team";
    }

}

?>


<!DOCTYPE html>
<html>


<head>

<title>
Create Research Team - ScholarX
</title>

</head>


<body>


<h1>
Create Research Team
</h1>


<a href="teams.php">
← Back to Teams
</a>


<br><br>



<p>

<?= $message; ?>

</p>



<form method="POST">


<label>
Team Name
</label>

<br>


<input

type="text"

name="name"

placeholder="Enter Team Name"

required>


<br><br>



<label>
Team Description
</label>

<br>


<textarea

name="description"

rows="5"

cols="40"

placeholder="Enter Team Description">

</textarea>


<br><br>



<button name="create">

Create Team

</button>



</form>



</body>


</html>