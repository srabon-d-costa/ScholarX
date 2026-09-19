<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/MilestoneController.php";


checkLogin();

checkRole(3);



$milestone = new MilestoneController();



if(!isset($_GET['project_id']))
{
    header("Location: projects.php");
    exit();
}



$project_id = $_GET['project_id'];



$message = "";



if(isset($_POST['create']))
{

    $result = $milestone->createMilestone(

        $project_id,

        $_POST['title'],

        $_POST['description'],

        $_POST['deadline']

    );


    if($result)
    {
        $message = "Milestone Created Successfully";
    }
    else
    {
        $message = "Failed To Create Milestone";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Create Milestone - ScholarX
</title>

</head>


<body>


<h1>
Create Research Milestone
</h1>



<a href="project_details.php?id=<?= $project_id; ?>">

← Back to Project

</a>


<br><br>



<p>

<?= $message; ?>

</p>




<form method="POST">



<label>
Milestone Title
</label>


<br>


<input

type="text"

name="title"

placeholder="Example: Dataset Preparation"

required>



<br><br>





<label>
Milestone Description
</label>


<br>


<textarea

name="description"

rows="5"

cols="40"

placeholder="Describe milestone task"

required>

</textarea>



<br><br>





<label>
Deadline
</label>


<br>


<input

type="date"

name="deadline"

required>



<br><br>

<button name="create">

Create Milestone

</button>



</form>



</body>


</html>