<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AnnouncementController.php";

checkLogin();
checkRole(4);

$announcement = new AnnouncementController();

$announcements = $announcement->announcements();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Announcements - ScholarX</title>

</head>

<body>

<h1>Manage Announcements</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<a href="create_announcement.php">
    <button type="button">
        Create Announcement
    </button>
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>

        <th>ID</th>

        <th>Title</th>

        <th>Content</th>

        <th>Created By</th>

        <th>Target Role</th>

        <th>Target Department</th>

        <th>Status</th>

        <th>Created At</th>

        <th>Action</th>

    </tr>

    <?php if(count($announcements) > 0): ?>

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
                    <?= htmlspecialchars($item['creator_name'] ?? 'Unknown'); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['target_role']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['target_department'] ?? 'All'); ?>
                </td>

                <td>

                    <?php if($item['is_active'] == 1): ?>

                        Active

                    <?php else: ?>

                        Inactive

                    <?php endif; ?>

                </td>

                <td>
                    <?= htmlspecialchars($item['created_at']); ?>
                </td>

                <td>

                    <a href="edit_announcement.php?id=<?= $item['id']; ?>">
                        Edit
                    </a>

                    |

                    <?php if($item['is_active'] == 1): ?>

                        <a href="toggle_announcement.php?id=<?= $item['id']; ?>&status=0">
                            Deactivate
                        </a>

                    <?php else: ?>

                        <a href="toggle_announcement.php?id=<?= $item['id']; ?>&status=1">
                            Activate
                        </a>

                    <?php endif; ?>

                    |

                    <a
                        href="delete_announcement.php?id=<?= $item['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this announcement?');"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>

            <td colspan="9">
                No announcements found.
            </td>

        </tr>

    <?php endif; ?>

</table>

</body>

</html>