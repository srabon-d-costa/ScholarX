<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ProposalController.php";


checkLogin();

checkRole(3);



$proposal = new ProposalController();



$proposals = $proposal->supervisorProposals(

    $_SESSION['user_id']

);


?>


<!DOCTYPE html>
<html>


<head>

<title>
Research Proposals - ScholarX
</title>

</head>


<body>


<h1>
Research Proposal Review
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
Opportunity
</th>


<th>
Title
</th>


<th>
Abstract
</th>


<th>
Status
</th>


<th>
Action
</th>


</tr>




<?php if(count($proposals) > 0): ?>


<?php foreach($proposals as $item): ?>


<tr>


<td>

<?= $item['id']; ?>

</td>




<td>

<?= $item['opportunity_title']; ?>

</td>




<td>

<?= $item['title']; ?>

</td>




<td>

<?= $item['abstract']; ?>

</td>




<td>

<?= $item['status']; ?>

</td>




<td>


<?php if($item['status']=="Submitted"): ?>


<a href="update_proposal_status.php?id=<?= $item['id']; ?>&status=Approved">

Approve

</a>


|

<a href="update_proposal_status.php?id=<?= $item['id']; ?>&status=Rejected">

Reject

</a>


<?php else: ?>


Reviewed


<?php endif; ?>


</td>



</tr>


<?php endforeach; ?>



<?php else: ?>


<tr>

<td colspan="6">

No Proposals Found

</td>

</tr>


<?php endif; ?>



</table>



</body>


</html>