<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";
require_once "../../controllers/DepartmentController.php";

checkLogin();
checkRole(1);


$announcementController = new AnnouncementController();
$departmentController = new DepartmentController();


if(!isset($_GET['id']))
{
    header("Location: announcements.php");
    exit();
}


$id = $_GET['id'];


$announcement =
    $announcementController->announcementDetails($id);


if(!$announcement)
{
    echo "Announcement not found.";
    exit();
}


$departments =
    $departmentController->departments();


$message = "";


if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $target_role = $_POST['target_role'];

    $target_department =
        !empty($_POST['target_department'])
        ? $_POST['target_department']
        : null;


    if($title == "" || $content == "")
    {
        $message =
            "Title and content are required.";
    }
    else
    {
        $result =
            $announcementController->updateAnnouncement(

                $id,
                $title,
                $content,
                $target_role,
                $target_department

            );


        if($result)
        {
            header(
                "Location: announcements.php"
            );

            exit();
        }
        else
        {
            $message =
                "Failed to update announcement.";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>
        Edit Announcement - ScholarX
    </title>

</head>


<body>


<h1>
    Edit Announcement
</h1>


<a href="announcements.php">
    ← Back to Announcements
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
        $announcement['title']
    ); ?>"
    size="60"
    required
>


<br><br>


<label>
    Content
</label>

<br>

<textarea
    name="content"
    rows="8"
    cols="60"
    required
><?= htmlspecialchars(
    $announcement['content']
); ?></textarea>


<br><br>


<label>
    Target Role
</label>

<br>

<select name="target_role">

    <option
        value="All"
        <?= $announcement['target_role'] == 'All'
            ? 'selected'
            : ''; ?>
    >
        All
    </option>


    <option
        value="Student"
        <?= $announcement['target_role'] == 'Student'
            ? 'selected'
            : ''; ?>
    >
        Student
    </option>

</select>


<br><br>


<label>
    Target Department
</label>

<br>

<select name="target_department">

    <option value="">
        All Departments
    </option>


    <?php foreach($departments as $department): ?>

        <option
            value="<?= $department['id']; ?>"
            <?= $announcement['target_department']
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


<button
    type="submit"
    name="update"
>
    Update Announcement
</button>


</form>


</body>

</html>