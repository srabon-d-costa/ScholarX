<?php

session_start();

require_once "../../controllers/AuthController.php";

$message = "";

if(isset($_POST['login']))
{
    $auth = new AuthController();

    $result = $auth->login(
        trim($_POST['email']),
        $_POST['password']
    );


    if($result === true)
    {
        if($_SESSION['role_id'] == 1)
        {
            header("Location: ../admin/dashboard.php");
        }
        elseif($_SESSION['role_id'] == 2)
        {
            header("Location: ../student/dashboard.php");
        }
        elseif($_SESSION['role_id'] == 3)
        {
            header("Location: ../supervisor/dashboard.php");
        }
        elseif($_SESSION['role_id'] == 4)
        {
            header("Location: ../coordinator/dashboard.php");
        }
        else
        {
            header("Location: login.php");
        }

        exit();
    }
    else
    {
        $message = $result;
    }
}

?>


<!DOCTYPE html>
<html>

<head>

<title>ScholarX Login</title>

</head>

<body>

<h2>ScholarX Login</h2>

<p>
<?= $message; ?>
</p>


<form method="POST">

<label>Email</label>
<br>

<input type="email" name="email" required>

<br><br>


<label>Password</label>
<br>

<input type="password" name="password" required>

<br><br>


<button name="login">
Login
</button>

<p>
    Don't have an account?
    <a href="register.php">Register here</a>
</p>

</form>

</body>

</html>