<?php

require_once "../../controllers/AuthController.php";

$message = "";

if(isset($_POST['register']))
{
    $auth = new AuthController();

    $result = $auth->register(
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        $_POST['role_id'],
        $_POST['department_id']
    );

    $message = $result;
}

?>


<!DOCTYPE html>
<html>

<head>

<title>ScholarX Registration</title>

</head>


<body>

<h2>
ScholarX Registration
</h2>


<p>
<?php echo $message; ?>
</p>


<form method="POST">


<label>Name</label>
<br>

<input type="text" name="name" required>

<br><br>



<label>Email</label>
<br>

<input type="email" name="email" required>

<br><br>



<label>Password</label>
<br>

<input type="password" name="password" required>

<br><br>



<label>Role</label>
<br>

<select name="role_id">

<option value="2">
Student
</option>


<option value="3">
Supervisor
</option>


<option value="4">
Coordinator
</option>

</select>


<br><br>



<label>Department</label>
<br>

<select name="department_id">

<option value="1">
CSE
</option>


<option value="2">
EEE
</option>


<option value="3">
BBA
</option>

</select>


<br><br>



<button name="register">
Register
</button>

<p>
    Already have an account?
    <a href="login.php">Login here</a>
</p>


</form>


</body>

</html>