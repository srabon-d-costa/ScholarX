<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);


$admin = new AdminController();



if(isset($_GET['search']) && !empty($_GET['search']))
{
    $users = $admin->searchUsers($_GET['search']);
}
else
{
    $users = $admin->users();
}

?>


<!DOCTYPE html>
<html>

<head>

<title>Manage Users - ScholarX</title>

</head>


<body>


<h1>
ScholarX User Management
</h1>


<a href="dashboard.php">
← Back to Dashboard
</a>


<br><br>



<form method="GET">

<input
type="text"
name="search"
placeholder="Search name or email">


<button type="submit">
Search
</button>


</form>


<br>



<table border="1" cellpadding="10">


<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Department</th>
<th>Status</th>
<th>Created</th>
<th>Action</th>

</tr>



<?php foreach($users as $user): ?>


<tr>


<td>
<?= $user['id']; ?>
</td>


<td>
<?= $user['name']; ?>
</td>


<td>
<?= $user['email']; ?>
</td>


<td>
<?= $user['role_name']; ?>
</td>


<td>
<?= $user['department'] ?? "N/A"; ?>
</td>


<td>
<?= $user['status']; ?>
</td>


<td>
<?= $user['created_at']; ?>
</td>



<td>


<a href="view_user.php?id=<?= $user['id']; ?>">
View
</a>

|

<a href="edit_user.php?id=<?= $user['id']; ?>">
Edit
</a>


|


<?php if($user['status'] == "active"): ?>


<a href="change_status.php?id=<?= $user['id']; ?>&status=inactive">
Deactivate
</a>


<?php else: ?>


<a href="change_status.php?id=<?= $user['id']; ?>&status=active">
Activate
</a>


<?php endif; ?>


|


<a
href="delete_user.php?id=<?= $user['id']; ?>"
onclick="return confirm('Are you sure you want to delete this user?');">

Delete

</a>


</td>



</tr>


<?php endforeach; ?>


</table>


</body>

</html>