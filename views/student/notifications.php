<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/NotificationController.php";

checkLogin();
checkRole(2); // Student only


$notification = new NotificationController();

$user_id = $_SESSION['user_id'];


// --------------------------------------------------
// Mark single notification as read
// --------------------------------------------------

if(isset($_GET['read']))
{
    $notification_id = $_GET['read'];

    $notification->markAsRead(
        $notification_id,
        $user_id
    );

    header("Location: notifications.php");
    exit();
}


// --------------------------------------------------
// Mark all notifications as read
// --------------------------------------------------

if(isset($_GET['read_all']))
{
    $notification->markAllAsRead(
        $user_id
    );

    header("Location: notifications.php");
    exit();
}


// --------------------------------------------------
// Get all notifications
// --------------------------------------------------

$notifications = $notification->userNotifications(
    $user_id
);


// --------------------------------------------------
// Get unread notification count
// --------------------------------------------------

$unreadCount = $notification->unreadCount(
    $user_id
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        My Notifications - ScholarX
    </title>

</head>


<body>


<h1>
    My Notifications
</h1>


<a href="dashboard.php">
    ← Back to Dashboard
</a>


<br><br>


<h2>
    Notifications
</h2>


<p>

    Unread Notifications:

    <strong>
        <?= htmlspecialchars($unreadCount); ?>
    </strong>

</p>


<?php if($unreadCount > 0): ?>

    <a href="notifications.php?read_all=1">
        Mark All As Read
    </a>

<?php endif; ?>


<br><br>


<?php if(count($notifications) > 0): ?>


<table border="1" cellpadding="10">

    <tr>

        <th>
            ID
        </th>

        <th>
            Type
        </th>

        <th>
            Message
        </th>

        <th>
            Status
        </th>

        <th>
            Date
        </th>

        <th>
            Action
        </th>

    </tr>


    <?php foreach($notifications as $item): ?>

    <tr>

        <td>
            <?= htmlspecialchars($item['id']); ?>
        </td>


        <td>
            <?= htmlspecialchars($item['type']); ?>
        </td>


        <td>
            <?= htmlspecialchars($item['message']); ?>
        </td>


        <td>

            <?php if($item['is_read'] == 0): ?>

                <strong>
                    Unread
                </strong>

            <?php else: ?>

                Read

            <?php endif; ?>

        </td>


        <td>
            <?= htmlspecialchars($item['created_at']); ?>
        </td>


        <td>

            <?php if($item['is_read'] == 0): ?>

                <a
                    href="notifications.php?read=<?= $item['id']; ?>"
                >
                    Mark as Read
                </a>

            <?php else: ?>

                Already Read

            <?php endif; ?>

        </td>

    </tr>

    <?php endforeach; ?>


</table>


<?php else: ?>


<p>
    No notifications available.
</p>


<?php endif; ?>


</body>

</html>