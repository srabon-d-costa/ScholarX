<?php

require_once __DIR__ . "/../models/Admin.php";


class AdminController
{
    private $adminModel;


    public function __construct()
    {
        $this->adminModel = new Admin();
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
        return $this->adminModel->updateUserStatus(
            $user_id,
            $status
        );
    }




    // Delete user
    public function deleteUser($user_id)
    {
        return $this->adminModel->deleteUser($user_id);
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
        return $this->adminModel->updateUser(
            $id,
            $name,
            $email,
            $role_id,
            $department_id,
            $status
        );
    }

    // Get all departments
    public function departments()
    {
        return $this->adminModel->getDepartments();
    }

}

?>