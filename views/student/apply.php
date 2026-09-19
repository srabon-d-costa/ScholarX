<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ApplicationController.php";
require_once "../../controllers/StudentController.php";


checkLogin();

checkRole(2);



$application = new ApplicationController();

$student = new StudentController();



if(!isset($_GET['id']))
{
    header("Location: opportunities.php");
    exit();
}



$opportunity_id = $_GET['id'];



$opportunity = $student->opportunityDetails($opportunity_id);



if(!$opportunity)
{
    echo "Research Opportunity Not Found";
    exit();
}



$message = "";



if(isset($_POST['apply']))
{

    $already = $application->alreadyApplied(
        $opportunity_id,
        $_SESSION['user_id']
    );



    if($already)
    {
        $message = "You already applied for this opportunity";
    }
    else
    {

        $result = $application->apply(

            $opportunity_id,

            $_SESSION['user_id'],

            $_POST['message']

        );


        if($result)
        {
            $message = "Application Submitted Successfully";
        }
        else
        {
            $message = "Application Failed";
        }

    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Apply Research Opportunity - ScholarX
</title>

</head>


<body>


<h1>
Apply For Research Opportunity
</h1>


<a href="view_opportunity.php?id=<?= $opportunity_id; ?>">
← Back to Opportunity
</a>


<br><br>



<p>

<?= $message; ?>

</p>



<h3>
<?= $opportunity['title']; ?>
</h3>



<p>

Supervisor:
<?= $opportunity['supervisor_name']; ?>

</p>



<p>

Department:
<?= $opportunity['department_name']; ?>

</p>



<form method="POST">


<label>

Application Message

</label>


<br>


<textarea

name="message"

rows="6"

cols="50"

placeholder="Write why you want to join this research project..."

required></textarea>



<br><br>



<button name="apply">

Submit Application

</button>



</form>



</body>


</html>