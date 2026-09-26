<?php

require_once __DIR__ . "/../models/Admin.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class AdminController
{
    private $adminModel;
    private $activityLog;


    public function __construct()
    {
        $this->adminModel = new Admin();
        $this->activityLog = new ActivityLogController();
    }



    // Dashboard Statistics
    public function dashboard()
    {
        return [

            "totalUsers" =>
            $this->adminModel->countUsers(),


            "totalStudents" =>
            $this->adminModel->countUsersByRole(2),


            "totalSupervisors" =>
            $this->adminModel->countUsersByRole(3),


            "totalCoordinators" =>
            $this->adminModel->countUsersByRole(4)

        ];
    }




    // Get all users
    public function users()
    {
        return $this->adminModel->getAllUsers();
    }




    // Search users
    public function searchUsers($keyword)
    {
        return $this->adminModel->searchUsers($keyword);
    }




    // Get users by role
    public function usersByRole($role_id)
    {
        return $this->adminModel->getUsersByRole($role_id);
    }




    // Change user status
    public function changeStatus($user_id, $status)
    {
        $result = $this->adminModel->updateUserStatus(
            $user_id,
            $status
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Changed user ID " .
                $user_id .
                " status to " .
                $status
            );
        }


        return $result;
    }




    // Delete user
    public function deleteUser($user_id)
    {
        $result = $this->adminModel->deleteUser(
            $user_id
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted user ID: " . $user_id
            );
        }


        return $result;
    }




    // Get user details
    public function getUserById($id)
    {
        return $this->adminModel->getUserById($id);
    }




    // Update user information
    public function updateUser(
        $id,
        $name,
        $email,
        $role_id,
        $department_id,
        $status
    )
    {
        $result = $this->adminModel->updateUser(
            $id,
            $name,
            $email,
            $role_id,
            $department_id,
            $status
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Updated user ID: " .
                $id .
                " - " .
                $name
            );
        }


        return $result;
    }




    // Get all departments
    public function departments()
    {
        return $this->adminModel->getDepartments();
    }

}

?>