<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";


checkLogin();

checkRole(3);



$project = new ResearchProjectController();



$message = "";



if(isset($_POST['create']))
{

    $result = $project->createProject(

        $_POST['proposal_id'],

        $_POST['title'],

        $_POST['description'],

        $_SESSION['user_id'],

        $_POST['start_date'],

        $_POST['end_date']

    );


    if($result)
    {
        $message = "Research Project Created Successfully";
    }
    else
    {
        $message = "Failed To Create Research Project";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Create Research Project - ScholarX
</title>

</head>


<body>


<h1>
Create Research Project
</h1>


<a href="projects.php">

← Back to Projects

</a>


<br><br>



<p>

<?= $message; ?>

</p>




<form method="POST">



<label>
Proposal ID
</label>

<br>


<input

type="number"

name="proposal_id"

required>


<br><br>





<label>
Project Title
</label>

<br>


<input

type="text"

name="title"

required>



<br><br>





<label>
Project Description
</label>

<br>


<textarea

name="description"

rows="5"

cols="40"

required>

</textarea>



<br><br>





<label>
Start Date
</label>

<br>


<input

type="date"

name="start_date"

required>



<br><br>





<label>
End Date
</label>

<br>


<input

type="date"

name="end_date"

required>



<br><br>





<button name="create">

Create Project

</button>



</form>



</body>


</html>