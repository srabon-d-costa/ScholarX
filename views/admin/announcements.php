<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(1);


$announcementController = new AnnouncementController();

$message = "";


/*
|--------------------------------------------------------------------------
| Delete Announcement
|--------------------------------------------------------------------------
*/

if(isset($_POST['delete']))
{
    $id = $_POST['id'];

    $result = $announcementController->deleteAnnouncement($id);

    if($result)
    {
        $message = "Announcement deleted successfully.";
    }
    else
    {
        $message = "Failed to delete announcement.";
    }
}


/*
|--------------------------------------------------------------------------
| Activate / Deactivate
|--------------------------------------------------------------------------
*/

if(isset($_POST['change_status']))
{
    $id = $_POST['id'];
    $status = $_POST['is_active'];

    $result = $announcementController->updateStatus(
        $id,
        $status
    );

    if($result)
    {
        $message = "Announcement status updated successfully.";
    }
    else
    {
        $message = "Failed to update announcement status.";
    }
}


/*
|--------------------------------------------------------------------------
| Get announcements
|--------------------------------------------------------------------------
*/

$announcements = $announcementController->announcements();

?>


<!DOCTYPE html>
<html>

<head>

    <title>
        Manage Announcements - ScholarX
    </title>

</head>


<body>


<h1>
    Manage Announcements
</h1>


<a href="dashboard.php">
    ← Back to Dashboard
</a>


<br><br>


<a href="create_announcement.php">
    + Create New Announcement
</a>


<br><br>


<?php if($message != ""): ?>

    <p>
        <strong>
            <?= htmlspecialchars($message); ?>
        </strong>
    </p>

<?php endif; ?>


<h2>
    All Announcements
</h2>


<?php if(count($announcements) > 0): ?>


<table border="1" cellpadding="10">

    <tr>

        <th>
            ID
        </th>

        <th>
            Title
        </th>

        <th>
            Content
        </th>

        <th>
            Created By
        </th>

        <th>
            Target Role
        </th>

        <th>
            Target Department
        </th>

        <th>
            Status
        </th>

        <th>
            Created
        </th>

        <th>
            Action
        </th>

    </tr>


    <?php foreach($announcements as $item): ?>

    <tr>

        <td>
            <?= htmlspecialchars($item['id']); ?>
        </td>


        <td>
            <?= htmlspecialchars($item['title']); ?>
        </td>


        <td>
            <?= htmlspecialchars($item['content']); ?>
        </td>


        <td>
            <?= htmlspecialchars(
                $item['creator_name'] ?? 'Unknown'
            ); ?>
        </td>


        <td>
            <?= htmlspecialchars(
                $item['target_role'] ?? 'All'
            ); ?>
        </td>


        <td>
            <?= htmlspecialchars(
                $item['target_department'] ?? 'All Departments'
            ); ?>
        </td>


        <td>

            <?php if($item['is_active'] == 1): ?>

                Active

            <?php else: ?>

                Inactive

            <?php endif; ?>

        </td>


        <td>
            <?= htmlspecialchars(
                $item['created_at']
            ); ?>
        </td>


        <td>

            <a href="edit_announcement.php?id=<?= $item['id']; ?>">
                Edit
            </a>

            |

            <form
                method="POST"
                style="display:inline;"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($item['id']); ?>"
                >

                <input
                    type="hidden"
                    name="is_active"
                    value="<?= $item['is_active'] == 1 ? 0 : 1; ?>"
                >

                <button
                    type="submit"
                    name="change_status"
                >

                    <?= $item['is_active'] == 1
                        ? "Deactivate"
                        : "Activate"; ?>

                </button>

            </form>


            |


            <form
                method="POST"
                style="display:inline;"
                onsubmit="return confirm('Are you sure you want to delete this announcement?');"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($item['id']); ?>"
                >

                <button
                    type="submit"
                    name="delete"
                >
                    Delete
                </button>

            </form>

        </td>

    </tr>

    <?php endforeach; ?>


</table>


<?php else: ?>


<p>
    No announcements found.
</p>


<?php endif; ?>


</body>

</html>