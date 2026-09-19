<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/FeedbackController.php";
require_once "../../controllers/ResearchController.php";
require_once "../../controllers/TeamController.php";


checkLogin();

checkRole(3);



$feedback = new FeedbackController();

$research = new ResearchController();

$team = new TeamController();



$message = "";



// Load projects created by supervisor
$projects = $research->opportunities();



// Load students
$students = $team->students();





if(isset($_POST['submit']))
{

    $result = $feedback->createFeedback(

        $_POST['project_id'],

        $_SESSION['user_id'],

        $_POST['student_id'],

        $_POST['message'],

        $_POST['rating']

    );



    if($result)
    {
        $message = "Feedback Submitted Successfully";
    }
    else
    {
        $message = "Failed To Submit Feedback";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Give Feedback - ScholarX
</title>

</head>



<body>


<h1>
Give Research Feedback
</h1>



<a href="dashboard.php">

← Back to Dashboard

</a>


<br><br>



<p>

<?= $message; ?>

</p>




<form method="POST">



<label>
Select Research Project
</label>

<br>


<select name="project_id" required>


<option value="">
Select Project
</option>



<?php foreach($projects as $project): ?>


<option value="<?= $project['id']; ?>">

<?= $project['title']; ?>

</option>


<?php endforeach; ?>


</select>



<br><br>





<label>
Select Student
</label>


<br>



<select name="student_id" required>


<option value="">
Select Student
</option>



<?php foreach($students as $student): ?>


<option value="<?= $student['id']; ?>">

<?= $student['name']; ?>

-
<?= $student['email']; ?>

</option>


<?php endforeach; ?>


</select>



<br><br>





<label>
Feedback Message
</label>


<br>



<textarea

name="message"

rows="5"

cols="40"

required>

</textarea>



<br><br>





<label>
Rating (1-5)
</label>


<br>



<input

type="number"

name="rating"

min="1"

max="5"

value="5"

required>



<br><br>





<button name="submit">

Submit Feedback

</button>



</form>



</body>


</html>