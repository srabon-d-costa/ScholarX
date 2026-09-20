<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ProposalController.php";
require_once "../../controllers/TeamController.php";
require_once "../../controllers/ResearchController.php";


checkLogin();

checkRole(2);



$proposal = new ProposalController();

$team = new TeamController();

$research = new ResearchController();



$message = "";



// Load student teams
$teams = $team->studentTeams($_SESSION['user_id']);



// Load opportunities
$opportunities = $research->opportunities();





if(isset($_POST['submit']))
{

    $result = $proposal->createProposal(

        $_POST['opportunity_id'],

        $_POST['team_id'],

        $_POST['title'],

        $_POST['abstract'],

        null

    );


    if($result)
    {
        $message = "Proposal Submitted Successfully";
    }
    else
    {
        $message = "Failed To Submit Proposal";
    }

}


?>


<!DOCTYPE html>
<html>


<head>

<title>
Submit Research Proposal - ScholarX
</title>

</head>


<body>


<h1>
Submit Research Proposal
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
Select Research Opportunity
</label>

<br>



<select name="opportunity_id" required>


<option value="">
Select Opportunity
</option>



<?php foreach($opportunities as $opportunity): ?>


<option value="<?= $opportunity['id']; ?>">

<?= $opportunity['title']; ?>

</option>


<?php endforeach; ?>


</select>



<br><br>





<label>
Select Team
</label>

<br>



<select name="team_id" required>


<option value="">
Select Team
</option>



<?php foreach($teams as $teamData): ?>


<option value="<?= $teamData['id']; ?>">

<?= $teamData['name']; ?>

</option>


<?php endforeach; ?>


</select>



<br><br>





<label>
Proposal Title
</label>

<br>



<input

type="text"

name="title"

placeholder="Research Proposal Title"

required>



<br><br>





<label>
Abstract
</label>

<br>



<textarea

name="abstract"

rows="6"

cols="50"

placeholder="Write research abstract"

required>

</textarea>



<br><br>




<button name="submit">

Submit Proposal

</button>



</form>



</body>


</html>