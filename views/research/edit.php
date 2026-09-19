<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";

checkLogin();
checkRole(3);


$research = new ResearchController();


if(!isset($_GET['id']))
{
    header("Location: manage.php");
    exit();
}


$id = $_GET['id'];


$opportunity = $research->opportunityDetails($id);


if(!$opportunity)
{
    echo "Research Opportunity Not Found";
    exit();
}


$categories = $research->categories();

$departments = $research->departments();


$message = "";


if(isset($_POST['update']))
{

    $result = $research->updateOpportunity(
        $id,
        $_POST['title'],
        $_POST['description'],
        $_POST['category_id'],
        $_POST['department_id'],
        $_POST['required_skills'],
        $_POST['max_members'],
        $_POST['deadline'],
        $_POST['status']
    );


    if($result)
    {
        $message = "Research Opportunity Updated Successfully";
        $opportunity = $research->opportunityDetails($id);
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
Edit Research Opportunity
</title>

</head>


<body>


<h1>
Edit Research Opportunity
</h1>


<a href="manage.php">
← Back to Opportunities
</a>


<br><br>


<p>
<?= $message; ?>
</p>



<form method="POST">


<label>
Research Title
</label>

<br>

<input 
type="text"
name="title"
value="<?= $opportunity['title']; ?>"
required>


<br><br>



<label>
Description
</label>

<br>

<textarea
name="description"
rows="5"
cols="40"
required><?= $opportunity['description']; ?></textarea>


<br><br>



<label>
Research Category
</label>

<br>

<select name="category_id" required>

<?php foreach($categories as $category): ?>

<option 
value="<?= $category['id']; ?>"
<?= ($category['id'] == $opportunity['category_id']) ? "selected" : ""; ?>>

<?= $category['name']; ?>

</option>

<?php endforeach; ?>

</select>


<br><br>



<label>
Department
</label>

<br>

<select name="department_id" required>

<?php foreach($departments as $department): ?>

<option
value="<?= $department['id']; ?>"
<?= ($department['id'] == $opportunity['department_id']) ? "selected" : ""; ?>>

<?= $department['name']; ?>

</option>

<?php endforeach; ?>

</select>


<br><br>



<label>
Required Skills
</label>

<br>

<textarea
name="required_skills"
rows="3"
cols="40"><?= $opportunity['required_skills']; ?></textarea>


<br><br>



<label>
Maximum Members
</label>

<br>

<input
type="number"
name="max_members"
value="<?= $opportunity['max_members']; ?>">


<br><br>



<label>
Deadline
</label>

<br>

<input
type="date"
name="deadline"
value="<?= $opportunity['deadline']; ?>">


<br><br>



<label>
Status
</label>

<br>

<select name="status">

<option value="Open"
<?= ($opportunity['status']=="Open") ? "selected" : ""; ?>>
Open
</option>


<option value="Closed"
<?= ($opportunity['status']=="Closed") ? "selected" : ""; ?>>
Closed
</option>

</select>


<br><br>



<button name="update">

Update Opportunity

</button>


</form>


</body>

</html>