<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/MilestoneController.php";

checkLogin();
checkRole(3);

$milestoneController = new MilestoneController();

if(!isset($_GET['project_id']))
{
    header("Location: projects.php");
    exit();
}

$project_id = $_GET['project_id'];

$message = "";

if(isset($_POST['create']))
{
    $result = $milestoneController->createMilestone(

        $project_id,

        $_POST['title'],

        $_POST['description'],

        $_POST['due_date']

    );

    if($result)
    {
        // Go directly to milestone list
        header(
            "Location: milestones.php?project_id=" . $project_id
        );

        exit();
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
Create Research Milestone - ScholarX
</title>

</head>

<body>

<h1>
Create Research Milestone
</h1>

<a href="milestones.php?project_id=<?= $project_id; ?>">

← Back to Milestones

</a>

<br><br>

<?php if($message != ""): ?>

<p>
<?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>


<form method="POST">


<label>
Milestone Title
</label>

<br>

<input
type="text"
name="title"
placeholder="Example: Dataset Preparation"
required
>


<br><br>


<label>
Milestone Description
</label>

<br>

<textarea
name="description"
rows="5"
cols="40"
required
></textarea>


<br><br>


<label>
Due Date
</label>

<br>

<input
type="date"
name="due_date"
required
>


<br><br>


<button
type="submit"
name="create"
>

Create Milestone

</button>


</form>


</body>

</html>