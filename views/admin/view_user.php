<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);



if(!isset($_GET['id']))
{
    header("Location: users.php");
    exit();
}



$admin = new AdminController();


$user = $admin->getUserById(
    $_GET['id']
);



if(!$user)
{
    echo "User not found";
    exit();
}

?>


<!DOCTYPE html>
<html>

<head>

<title>User Profile - ScholarX</title>

</head>


<body>


<h1>
ScholarX User Profile
</h1>


<a href="users.php">
← Back to Users
</a>


<br><br>



<table border="1" cellpadding="10">


<tr>

<th>ID</th>

<td>
<?= $user['id']; ?>
</td>

</tr>



<tr>

<th>Name</th>

<td>
<?= $user['name']; ?>
</td>

</tr>



<tr>

<th>Email</th>

<td>
<?= $user['email']; ?>
</td>

</tr>



<tr>

<th>Role</th>

<td>
<?= $user['role_name']; ?>
</td>

</tr>



<tr>

<th>Department</th>

<td>
<?= $user['department'] ?? "N/A"; ?>
</td>

</tr>



<tr>

<th>Status</th>

<td>
<?= $user['status']; ?>
</td>

</tr>



<tr>

<th>Created Date</th>

<td>
<?= $user['created_at']; ?>
</td>

</tr>



</table>


</body>

</html>