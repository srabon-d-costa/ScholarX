<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class AuthController
{
    private $userModel;
    private $activityLog;


    public function __construct()
    {
        $this->userModel = new User();
        $this->activityLog = new ActivityLogController();
    }


    // Password Strength Validation
    private function validatePassword($password)
    {
        if(strlen($password) < 8)
        {
            return false;
        }


        if(!preg_match('/[A-Z]/', $password))
        {
            return false;
        }


        if(!preg_match('/[a-z]/', $password))
        {
            return false;
        }


        if(!preg_match('/[0-9]/', $password))
        {
            return false;
        }


        if(!preg_match('/[\W]/', $password))
        {
            return false;
        }


        return true;
    }


    // Register User
    public function register(
        $name,
        $email,
        $password,
        $role_id,
        $department_id
    )
    {
        $existingUser = $this->userModel->findByEmail(
            $email
        );


        if($existingUser)
        {
            return "Email already exists";
        }


        if(!$this->validatePassword($password))
        {
            return "Password must contain minimum 8 characters with uppercase, lowercase, number and special character";
        }


        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        $result = $this->userModel->createUser(
            $name,
            $email,
            $hashedPassword,
            $role_id,
            $department_id
        );


        if($result)
        {
            return "Registration successful";
        }


        return "Registration failed";
    }


    // Login User
    public function login(
        $email,
        $password
    )
    {
        $user = $this->userModel->findByEmail(
            $email
        );


        if(!$user)
        {
            return "User not found";
        }


        if(password_verify(
            $password,
            $user['password']
        ))
        {
            session_start();


            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role_id'] = $user['role_id'];


            // Log successful login
            $this->activityLog->log(
                $user['id'],
                "User logged in"
            );


            return true;
        }


        return "Invalid password";
    }


    // Logout User
    public function logout()
    {
        session_start();


        // Save user ID before destroying session
        $user_id = $_SESSION['user_id'] ?? null;


        // Log logout before destroying session
        if($user_id)
        {
            $this->activityLog->log(
                $user_id,
                "User logged out"
            );
        }


        session_destroy();


        header(
            "Location: ../views/auth/login.php"
        );

        exit();
    }
}

?>