<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/MilestoneController.php";


checkLogin();

checkRole(3);


$milestoneController = new MilestoneController();


if(!isset($_GET['id']))
{
    header("Location: projects.php");
    exit();
}


$id = $_GET['id'];


// Get milestone details
$milestone = $milestoneController->milestoneDetails($id);


if(!$milestone)
{
    echo "Milestone Not Found";
    exit();
}


$project_id = $milestone['project_id'];

$message = "";


// Update milestone status
if(isset($_POST['update']))
{

    $status = $_POST['status'];

    $result = $milestoneController->updateStatus(
        $id,
        $status
    );


    if($result)
    {
        $message = "Milestone Updated Successfully";

        // Refresh milestone data
        $milestone = $milestoneController->milestoneDetails($id);
    }
    else
    {
        $message = "Failed To Update Milestone";
    }

}


// Delete milestone
if(isset($_POST['delete']))
{

    $result = $milestoneController->deleteMilestone($id);


    if($result)
    {
        header(
            "Location: milestones.php?project_id=" . $project_id
        );

        exit();
    }
    else
    {
        $message = "Failed To Delete Milestone";
    }

}

?>


<!DOCTYPE html>
<html>


<head>

<title>
Milestone Details - ScholarX
</title>

</head>


<body>


<h1>
Milestone Details
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


<table border="1" cellpadding="10">


<tr>

<th>
Milestone ID
</th>

<td>
<?= $milestone['id']; ?>
</td>

</tr>


<tr>

<th>
Milestone Title
</th>

<td>
<?= htmlspecialchars($milestone['title']); ?>
</td>

</tr>


<tr>

<th>
Description
</th>

<td>
<?= htmlspecialchars($milestone['description']); ?>
</td>

</tr>


<tr>

<th>
Due Date
</th>

<td>
<?= htmlspecialchars($milestone['due_date']); ?>
</td>

</tr>


<tr>

<th>
Current Status
</th>

<td>
<?= htmlspecialchars($milestone['status']); ?>
</td>

</tr>


<tr>

<th>
Created At
</th>

<td>
<?= htmlspecialchars($milestone['created_at']); ?>
</td>

</tr>


</table>


<br><br>


<h2>
Update Milestone
</h2>


<form method="POST">


<label>
Status
</label>

<br>


<select name="status" required>


<option value="Pending"

<?php

if($milestone['status'] == 'Pending')
{
    echo 'selected';
}

?>

>

Pending

</option>


<option value="In Progress"

<?php

if($milestone['status'] == 'In Progress')
{
    echo 'selected';
}

?>

>

In Progress

</option>


<option value="Completed"

<?php

if($milestone['status'] == 'Completed')
{
    echo 'selected';
}

?>

>

Completed

</option>


</select>


<br><br>


<button
type="submit"
name="update"
>

Update Milestone

</button>


</form>


<br><br>


<h2>
Delete Milestone
</h2>


<form method="POST">


<button
type="submit"
name="delete"
onclick="return confirm('Are you sure you want to delete this milestone?');"
>

Delete Milestone

</button>


</form>


</body>

</html>