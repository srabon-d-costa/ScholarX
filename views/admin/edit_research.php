<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";

checkLogin();
checkRole(1);


$researchController = new ResearchController();


if(!isset($_GET['id']))
{
    header("Location: research.php");
    exit();
}


$id = $_GET['id'];


$opportunity =
    $researchController->opportunityDetails($id);


if(!$opportunity)
{
    echo "Research opportunity not found.";
    exit();
}


$categories =
    $researchController->categories();


$departments =
    $researchController->departments();


$message = "";


if(isset($_POST['update']))
{
    $title = trim($_POST['title']);

    $description = trim($_POST['description']);

    $category_id = $_POST['category_id'];

    $department_id = $_POST['department_id'];

    $required_skills = trim(
        $_POST['required_skills']
    );

    $max_members = $_POST['max_members'];

    $deadline = $_POST['deadline'];

    $status = $_POST['status'];


    if($title == "" || $description == "")
    {
        $message =
            "Title and description are required.";
    }
    else
    {
        $result =
            $researchController->updateOpportunity(

                $id,
                $title,
                $description,
                $category_id,
                $department_id,
                $required_skills,
                $max_members,
                $deadline,
                $status

            );


        if($result)
        {
            header(
                "Location: research.php"
            );

            exit();
        }
        else
        {
            $message =
                "Failed to update research opportunity.";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>
        Edit Research Opportunity - ScholarX
    </title>

</head>


<body>


<h1>
    Edit Research Opportunity
</h1>


<a href="research.php">
    ← Back to Research Opportunities
</a>


<br><br>


<?php if($message != ""): ?>

<p>
    <strong>
        <?= htmlspecialchars($message); ?>
    </strong>
</p>

<?php endif; ?>


<form method="POST">


<label>
    Title
</label>

<br>

<input
    type="text"
    name="title"
    value="<?= htmlspecialchars(
        $opportunity['title']
    ); ?>"
    size="60"
    required
>


<br><br>


<label>
    Description
</label>

<br>

<textarea
    name="description"
    rows="8"
    cols="60"
    required
><?= htmlspecialchars(
    $opportunity['description']
); ?></textarea>


<br><br>


<label>
    Research Category
</label>

<br>

<select name="category_id" required>

<?php foreach($categories as $category): ?>

    <option
        value="<?= $category['id']; ?>"
        <?= $opportunity['category_id']
            == $category['id']
            ? 'selected'
            : ''; ?>
    >

        <?= htmlspecialchars(
            $category['name']
        ); ?>

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
        <?= $opportunity['department_id']
            == $department['id']
            ? 'selected'
            : ''; ?>
    >

        <?= htmlspecialchars(
            $department['name']
        ); ?>

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
    rows="4"
    cols="60"
><?= htmlspecialchars(
    $opportunity['required_skills'] ?? ''
); ?></textarea>


<br><br>


<label>
    Maximum Members
</label>

<br>

<input
    type="number"
    name="max_members"
    min="1"
    value="<?= htmlspecialchars(
        $opportunity['max_members']
    ); ?>"
    required
>


<br><br>


<label>
    Deadline
</label>

<br>

<input
    type="date"
    name="deadline"
    value="<?= htmlspecialchars(
        $opportunity['deadline']
    ); ?>"
    required
>


<br><br>


<label>
    Status
</label>

<br>

<select name="status">

    <option
        value="Open"
        <?= ($opportunity['status'] ?? '') == 'Open'
            ? 'selected'
            : ''; ?>
    >
        Open
    </option>


    <option
        value="Closed"
        <?= ($opportunity['status'] ?? '') == 'Closed'
            ? 'selected'
            : ''; ?>
    >
        Closed
    </option>


    <option
        value="Draft"
        <?= ($opportunity['status'] ?? '') == 'Draft'
            ? 'selected'
            : ''; ?>
    >
        Draft
    </option>

</select>


<br><br>


<button
    type="submit"
    name="update"
>
    Update Research Opportunity
</button>


</form>


</body>

</html>