<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";
require_once "../../controllers/DepartmentController.php";

checkLogin();
checkRole(1);


$announcementController = new AnnouncementController();
$departmentController = new DepartmentController();

$message = "";

$departments = $departmentController->departments();


if(isset($_POST['create']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $target_role = $_POST['target_role'];

    $target_department = !empty($_POST['target_department'])
        ? $_POST['target_department']
        : null;


    if($title == "" || $content == "")
    {
        $message = "Title and content are required.";
    }
    else
    {
        $result = $announcementController->createAnnouncement(

            $title,
            $content,
            $_SESSION['user_id'],
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
            $message = "Failed to create announcement.";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>
        Create Announcement - ScholarX
    </title>

</head>


<body>


<h1>
    Create Announcement
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
    required
    size="60"
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
></textarea>


<br><br>


<label>
    Target Role
</label>

<br>

<select name="target_role">

    <option value="All">
        All
    </option>

    <option value="Student">
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

        <option value="<?= $department['id']; ?>">

            <?= htmlspecialchars(
                $department['name']
            ); ?>

        </option>

    <?php endforeach; ?>

</select>


<br><br>


<button
    type="submit"
    name="create"
>
    Create Announcement
</button>


</form>


</body>

</html>