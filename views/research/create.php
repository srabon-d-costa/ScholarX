<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";


checkLogin();

checkRole(3); // Supervisor only


$research = new ResearchController();


$message = "";


// Load dropdown data
$categories = $research->categories();

$departments = $research->departments();



if(isset($_POST['create']))
{

    $result = $research->createOpportunity(

        $_POST['title'],

        $_POST['description'],

        $_POST['category_id'],

        $_SESSION['user_id'],

        $_POST['department_id'],

        $_POST['required_skills'],

        $_POST['max_members'],

        $_POST['deadline']

    );


    if($result)
    {
        $message = "Research Opportunity Created Successfully";
    }
    else
    {
        $message = "Failed to Create Opportunity";
    }

}

?>


<!DOCTYPE html>
<html>


<head>

<title>
Create Research Opportunity - ScholarX
</title>

</head>


<body>


<h1>
Create Research Opportunity
</h1>


<a href="../supervisor/dashboard.php">
← Back to Dashboard
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
required></textarea>


<br><br>





<label>
Research Category
</label>

<br>


<select name="category_id" required>


<option value="">
Select Category
</option>



<?php foreach($categories as $category): ?>


<option value="<?= $category['id']; ?>">

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


<option value="">
Select Department
</option>



<?php foreach($departments as $department): ?>


<option value="<?= $department['id']; ?>">

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
cols="40">
</textarea>


<br><br>





<label>
Maximum Members
</label>

<br>


<input
type="number"
name="max_members"
value="5"
min="1">


<br><br>





<label>
Application Deadline
</label>

<br>


<input
type="date"
name="deadline">


<br><br>




<button name="create">

Create Opportunity

</button>



</form>


</body>


</html>