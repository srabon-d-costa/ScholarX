<?php


require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchProjectController.php";
require_once "../../controllers/ProposalController.php";

checkLogin();
checkRole(3);

$project = new ResearchProjectController();
$proposalController = new ProposalController();

$message = "";

// Get approved proposals
$approvedProposals = $proposalController->approvedProposals();

if(isset($_POST['create']))
{
    $result = $project->createProject(
        $_POST['proposal_id'],
        $_POST['title'],
        $_POST['description'],
        $_SESSION['user_id'],
        $_POST['start_date'],
        $_POST['end_date']
    );

    if($result)
    {
        $message = "Research Project Created Successfully";
    }
    else
    {
        $message = "Failed To Create Research Project";
    }

    // Refresh approved proposals after submission
    $approvedProposals = $proposalController->approvedProposals();
}

?>

<!DOCTYPE html>
<html>

<head><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg"><link rel="icon" type="image/svg+xml" href="/VarsityScholar/assets/images/favicon.svg">

<title>Create Research Project - VarsityScholar</title>

    <link rel="stylesheet" href="/VarsityScholar/assets/css/style.css">

</head>

<body>

<h1>
Create Research Project
</h1>

<a href="projects.php">
← Back to Projects
</a>

<br><br>

<p>
<?= htmlspecialchars($message); ?>
</p>

<form method="POST">

<label>
Select Approved Proposal
</label>

<br>

<select name="proposal_id" required>

<option value="">
Select an Approved Proposal
</option>

<?php foreach($approvedProposals as $proposal): ?>

<option value="<?= $proposal['id']; ?>">

<?= htmlspecialchars($proposal['title']); ?>

</option>

<?php endforeach; ?>

</select>

<br><br>


<label>
Project Title
</label>

<br>

<input
type="text"
name="title"
placeholder="Enter Project Title"
required>

<br><br>


<label>
Project Description
</label>

<br>

<textarea
name="description"
rows="5"
cols="40"
placeholder="Enter Project Description"
required></textarea>

<br><br>


<label>
Start Date
</label>

<br>

<input
type="date"
name="start_date"
required>

<br><br>


<label>
End Date
</label>

<br>

<input
type="date"
name="end_date"
required>

<br><br>


<button type="submit" name="create">
Create Project
</button>

</form>

    <script src="/VarsityScholar/assets/js/app.js"></script>

</body>

</html>