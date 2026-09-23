<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(4);

$announcement = new AnnouncementController();

$message = "";

if(isset($_POST['create']))
{
    $target_department = !empty($_POST['target_department'])
        ? $_POST['target_department']
        : null;

    $result = $announcement->createAnnouncement(
        $_POST['title'],
        $_POST['content'],
        $_SESSION['user_id'],
        $_POST['target_role'],
        $target_department
    );

    if($result)
    {
        header("Location: announcements.php");
        exit();
    }
    else
    {
        $message = "Failed to create announcement";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Announcement - ScholarX</title>

</head>

<body>

<h1>Create Announcement</h1>

<a href="announcements.php">
    ← Back to Announcements
</a>

<br><br>

<?php if($message != ""): ?>

<p>
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>

<form method="POST">

    <label>
        Announcement Title
    </label>

    <br>

    <input
        type="text"
        name="title"
        required
    >

    <br><br>

    <label>
        Announcement Content
    </label>

    <br>

    <textarea
        name="content"
        rows="6"
        cols="50"
        required
    ></textarea>

    <br><br>

    <label>
        Target Role
    </label>

    <br>

    <select name="target_role" required>

        <option value="All">
            All
        </option>

        <option value="Student">
            Student
        </option>

        <option value="Supervisor">
            Supervisor
        </option>

        <option value="Coordinator">
            Coordinator
        </option>

    </select>

    <br><br>

    <label>
        Target Department ID
    </label>

    <br>

    <input
        type="number"
        name="target_department"
        min="1"
        placeholder="Leave empty for all departments"
    >

    <br><br>

    <button
        type="submit"
        name="create"
    >
        Publish Announcement
    </button>

</form>

</body>

</html>