<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";


checkLogin();

checkRole(3);



$project = new ResearchProjectController();



if(!isset($_GET['id']))
{
    header("Location: projects.php");
    exit();
}



$id = $_GET['id'];



$projectData = $project->projectDetails($id);



if(!$projectData)
{
    echo "Project Not Found";
    exit();
}



$message = "";



if(isset($_POST['update']))
{

    $statusResult = $project->updateStatus(

        $id,

        $_POST['status']

    );


    $progressResult = $project->updateProgress(

        $id,

        $_POST['progress']

    );


    if($statusResult && $progressResult)
    {
        $message = "Project Updated Successfully";

        $projectData = $project->projectDetails($id);
    }
    else
    {
        $message = "Update Failed";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Project Details - ScholarX
</title>

</head>


<body>


<h1>
Research Project Details
</h1>



<a href="projects.php">

← Back to Projects

</a>


<br><br>



<p>

<?= $message; ?>

</p>




<table border="1" cellpadding="10">


<tr>

<th>
Project Title
</th>

<td>
<?= $projectData['title']; ?>
</td>

</tr>




<tr>

<th>
Description
</th>

<td>
<?= $projectData['description']; ?>
</td>

</tr>




<tr>

<th>
Start Date
</th>

<td>
<?= $projectData['start_date']; ?>
</td>

</tr>




<tr>

<th>
End Date
</th>

<td>
<?= $projectData['end_date']; ?>
</td>

</tr>




<tr>

<th>
Current Status
</th>

<td>
<?= $projectData['status']; ?>
</td>

</tr>




<tr>

<th>
Current Progress
</th>

<td>
<?= $projectData['progress']; ?>%
</td>

</tr>


</table>



<br><br>




<h2>
Update Project
</h2>




<form method="POST">


<label>
Status
</label>

<br>


<select name="status">


<option value="Pending"
<?= ($projectData['status']=="Pending") ? "selected":""; ?>>
Pending
</option>


<option value="Running"
<?= ($projectData['status']=="Running") ? "selected":""; ?>>
Running
</option>


<option value="Completed"
<?= ($projectData['status']=="Completed") ? "selected":""; ?>>
Completed
</option>


</select>


<br><br>




<label>
Progress (%)
</label>

<br>


<input

type="number"

name="progress"

min="0"

max="100"

value="<?= $projectData['progress']; ?>">



<br><br>



<button name="update">

Update Project

</button>



</form>



<br>



<a href="create_milestone.php?project_id=<?= $id; ?>">

<button>

Manage Milestones

</button>

</a>



</body>


</html>