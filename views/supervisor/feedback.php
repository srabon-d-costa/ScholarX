<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/FeedbackController.php";
require_once "../../controllers/ResearchProjectController.php";
require_once "../../controllers/TeamController.php";

checkLogin();
checkRole(3);

$feedbackController = new FeedbackController();
$projectController = new ResearchProjectController();
$teamController = new TeamController();

$supervisor_id = $_SESSION['user_id'];

$message = "";

// Load research projects created by this supervisor
$projects = $projectController->projects($supervisor_id);

// Load students
$students = $teamController->students();


// Submit feedback
if (isset($_POST['submit'])) {

    $project_id = $_POST['project_id'];
    $student_id = $_POST['student_id'];
    $feedback_message = trim($_POST['message']);
    $rating = $_POST['rating'];

    if (
        $project_id == "" ||
        $student_id == "" ||
        $feedback_message == ""
    ) {

        $message = "Please fill in all required fields.";

    } else {

        $result = $feedbackController->createFeedback(
            $project_id,
            $supervisor_id,
            $student_id,
            $feedback_message,
            $rating
        );

        if ($result) {

            $message = "Feedback Submitted Successfully";

        } else {

            $message = "Failed To Submit Feedback";

        }
    }
}


// Get feedback given by this supervisor
$feedbacks = $feedbackController->supervisorFeedback(
    $supervisor_id
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Give Feedback - ScholarX</title>

</head>

<body>

<h1>Give Research Feedback</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>


<?php if ($message != ""): ?>

<p>
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>


<h2>Submit Feedback</h2>


<form method="POST">

    <label>
        Select Research Project
    </label>

    <br>

    <select name="project_id" required>

        <option value="">
            Select Project
        </option>

        <?php foreach ($projects as $project): ?>

            <option value="<?= $project['id']; ?>">

                <?= htmlspecialchars($project['title']); ?>

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

        <?php foreach ($students as $student): ?>

            <option value="<?= $student['id']; ?>">

                <?= htmlspecialchars($student['name']); ?>

                -
                <?= htmlspecialchars($student['email']); ?>

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
        cols="50"
        required
    ></textarea>


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
        required
    >


    <br><br>


    <button
        type="submit"
        name="submit"
    >
        Submit Feedback
    </button>

</form>


<br>

<hr>

<br>


<h2>Feedback Given</h2>


<?php if (count($feedbacks) > 0): ?>

<table border="1" cellpadding="10">

    <tr>

        <th>
            Student
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


    <?php foreach ($feedbacks as $feedback): ?>

    <tr>

        <td>
            <?= htmlspecialchars($feedback['student_name']); ?>
        </td>

        <td>
            <?= htmlspecialchars($feedback['message']); ?>
        </td>

        <td>
            <?= htmlspecialchars($feedback['rating']); ?>/5
        </td>

        <td>
            <?= htmlspecialchars($feedback['created_at']); ?>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    No feedback has been given yet.
</p>

<?php endif; ?>


</body>

</html>