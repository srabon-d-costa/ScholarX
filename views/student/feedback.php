<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/FeedbackController.php";


checkLogin();

checkRole(2); // Student only



$feedback = new FeedbackController();



$feedbacks = $feedback->studentFeedback(

    $_SESSION['user_id']

);


?>


<!DOCTYPE html>
<html>


<head>

<title>
My Feedback - ScholarX
</title>

</head>


<body>


<h1>
My Research Feedback
</h1>



<a href="dashboard.php">

← Back to Dashboard

</a>


<br><br>




<table border="1" cellpadding="10">


<tr>

<th>
ID
</th>


<th>
Project ID
</th>


<th>
Supervisor
</th>


<th>
Feedback
</th>


<th>
Rating
</th>


<th>
Date
</th>


</tr>





<?php if(count($feedbacks) > 0): ?>


<?php foreach($feedbacks as $item): ?>


<tr>


<td>

<?= $item['id']; ?>

</td>



<td>

<?= $item['project_id']; ?>

</td>




<td>

<?= $item['supervisor_name']; ?>

</td>





<td>

<?= $item['message']; ?>

</td>





<td>

<?= $item['rating']; ?>/5

</td>





<td>

<?= $item['created_at']; ?>

</td>



</tr>



<?php endforeach; ?>



<?php else: ?>


<tr>

<td colspan="6">

No Feedback Available

</td>

</tr>



<?php endif; ?>



</table>



</body>


</html>