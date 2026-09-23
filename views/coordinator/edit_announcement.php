<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(4);

$announcement = new AnnouncementController();

if(!isset($_GET['id']))
{
    header("Location: announcements.php");
    exit();
}

$id = $_GET['id'];

$data = $announcement->announcementDetails($id);

if(!$data)
{
    echo "Announcement Not Found";
    exit();
}

$message = "";

if(isset($_POST['update']))
{
    $target_department = !empty($_POST['target_department'])
        ? $_POST['target_department']
        : null;

    $result = $announcement->updateAnnouncement(
        $id,
        $_POST['title'],
        $_POST['content'],
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
        $message = "Update Failed";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Announcement - ScholarX</title>

</head>

<body>

<h1>Edit Announcement</h1>

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
        value="<?= htmlspecialchars($data['title']); ?>"
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
    ><?= htmlspecialchars($data['content']); ?></textarea>

    <br><br>

    <label>
        Target Role
    </label>

    <br>

    <select name="target_role" required>

        <option
            value="All"
            <?= ($data['target_role'] == "All") ? "selected" : ""; ?>
        >
            All
        </option>

        <option
            value="Student"
            <?= ($data['target_role'] == "Student") ? "selected" : ""; ?>
        >
            Student
        </option>

        <option
            value="Supervisor"
            <?= ($data['target_role'] == "Supervisor") ? "selected" : ""; ?>
        >
            Supervisor
        </option>

        <option
            value="Coordinator"
            <?= ($data['target_role'] == "Coordinator") ? "selected" : ""; ?>
        >
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
        value="<?= htmlspecialchars($data['target_department'] ?? ''); ?>"
        placeholder="Leave empty for all departments"
    >

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