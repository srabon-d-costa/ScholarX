<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/TeamController.php";

checkLogin();
checkRole(3);

$teamController = new TeamController();

$message = "";

if (isset($_POST['create'])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name == "") {

        $message = "Team name is required.";

    } else {

        $result = $teamController->createTeam(
            $name,
            $description,
            $_SESSION['user_id']
        );

        if ($result) {

            $message = "Research Team Created Successfully";

        } else {

            $message = "Failed to Create Research Team";

        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Research Team - ScholarX</title>
</head>

<body>

<h1>Create Research Team</h1>

<a href="teams.php">
    ← Back to Teams
</a>

<br><br>

<?php if ($message != ""): ?>

<p>
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>

<form method="POST">

    <label>
        Team Name
    </label>

    <br>

    <input
        type="text"
        name="name"
        required
    >

    <br><br>

    <label>
        Team Description
    </label>

    <br>

    <textarea
        name="description"
        rows="5"
        cols="50"
    ></textarea>

    <br><br>

    <button
        type="submit"
        name="create"
    >
        Create Team
    </button>

</form>

</body>

</html>