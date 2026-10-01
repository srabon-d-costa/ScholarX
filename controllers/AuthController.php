<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";
require_once __DIR__ . "/../helpers/session.php";


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


        if(!password_verify(
            $password,
            $user['password']
        ))
        {
            return "Invalid password";
        }


        /*
        |--------------------------------------------------------------------------
        | Session Security
        |--------------------------------------------------------------------------
        */

        // Generate a new session ID after successful authentication
        session_regenerate_id(true);


        // Store authenticated user information
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];


        // Log successful login
        $this->activityLog->log(
            $user['id'],
            "User logged in"
        );


        return true;
    }


    // Logout User
    public function logout()
    {
        /*
        |--------------------------------------------------------------------------
        | Get current user
        |--------------------------------------------------------------------------
        */

        $user_id = $_SESSION['user_id'] ?? null;


        // Log logout before destroying session
        if($user_id)
        {
            $this->activityLog->log(
                $user_id,
                "User logged out"
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Session Data
        |--------------------------------------------------------------------------
        */

        $_SESSION = [];


        /*
        |--------------------------------------------------------------------------
        | Remove Session Cookie
        |--------------------------------------------------------------------------
        */

        if(ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();


            setcookie(
                session_name(),
                '',
                [
                    'expires' => time() - 42000,
                    'path' => $params['path'],
                    'domain' => $params['domain'],
                    'secure' => $params['secure'],
                    'httponly' => $params['httponly'],
                    'samesite' => $params['samesite'] ?? 'Lax'
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Destroy Session
        |--------------------------------------------------------------------------
        */

        session_destroy();


        /*
        |--------------------------------------------------------------------------
        | Redirect to Login
        |--------------------------------------------------------------------------
        */

        header(
            "Location: /ScholarX/views/auth/login.php"
        );

        exit();
    }
}

?>