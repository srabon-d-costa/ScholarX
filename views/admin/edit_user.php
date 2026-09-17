<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";


checkLogin();

checkRole(1);



$admin = new AdminController();



if(!isset($_GET['id']))
{
    header("Location: users.php");
    exit();
}



$id = $_GET['id'];



$user = $admin->getUserById($id);



if(!$user)
{
    echo "User not found";
    exit();
}



if(isset($_POST['update']))
{

    $result = $admin->updateUser(

        $id,

        $_POST['name'],

        $_POST['email'],

        $_POST['role_id'],

        $_POST['department_id'],

        $_POST['status']

    );


    if($result)
    {
        header("Location: users.php");
        exit();
    }

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Edit User - ScholarX</title>

</head>


<body>


<h1>
Edit User Profile
</h1>


<a href="users.php">
← Back to Users
</a>


<br><br>



<form method="POST">


<label>
Name
</label>

<br>

<input
type="text"
name="name"
value="<?= $user['name']; ?>"
required>


<br><br>



<label>
Email
</label>

<br>

<input
type="email"
name="email"
value="<?= $user['email']; ?>"
required>


<br><br>



<label>
Role
</label>

<br>


<select name="role_id">


<option value="1" <?= $user['role_id']==1 ? "selected" : ""; ?>>
Admin
</option>


<option value="2" <?= $user['role_id']==2 ? "selected" : ""; ?>>
Student
</option>


<option value="3" <?= $user['role_id']==3 ? "selected" : ""; ?>>
Supervisor
</option>


<option value="4" <?= $user['role_id']==4 ? "selected" : ""; ?>>
Coordinator
</option>


</select>


<br><br>



<label>
Department
</label>

<br>


<select name="department_id">


<option value="1" <?= $user['department_id']==1 ? "selected" : ""; ?>>
CSE
</option>


<option value="2" <?= $user['department_id']==2 ? "selected" : ""; ?>>
EEE
</option>


<option value="3" <?= $user['department_id']==3 ? "selected" : ""; ?>>
BBA
</option>


</select>


<br><br>



<label>
Status
</label>

<br>


<select name="status">


<option value="active" <?= $user['status']=="active" ? "selected" : ""; ?>>
Active
</option>


<option value="inactive" <?= $user['status']=="inactive" ? "selected" : ""; ?>>
Inactive
</option>


</select>


<br><br>



<button name="update">
Update User
</button>


</form>


</body>

</html>