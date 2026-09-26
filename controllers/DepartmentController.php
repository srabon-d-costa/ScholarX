<?php

require_once __DIR__ . "/../models/Department.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class DepartmentController
{
    private $departmentModel;
    private $activityLog;


    public function __construct()
    {
        $this->departmentModel = new Department();
        $this->activityLog = new ActivityLogController();
    }


    // Get all departments
    public function departments()
    {
        return $this->departmentModel->getAllDepartments();
    }


    // Get department details
    public function departmentDetails($id)
    {
        return $this->departmentModel->getDepartmentById($id);
    }


    // Create department
    public function createDepartment(
        $name,
        $code,
        $description
    )
    {
        $result = $this->departmentModel->createDepartment(
            $name,
            $code,
            $description
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Created department: " . $name .
                " (" . $code . ")"
            );
        }


        return $result;
    }


    // Update department
    public function updateDepartment(
        $id,
        $name,
        $code,
        $description
    )
    {
        $result = $this->departmentModel->updateDepartment(
            $id,
            $name,
            $code,
            $description
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Updated department ID: " . $id .
                " - " . $name .
                " (" . $code . ")"
            );
        }


        return $result;
    }


    // Delete department
    public function deleteDepartment($id)
    {
        $result = $this->departmentModel->deleteDepartment(
            $id
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted department ID: " . $id
            );
        }


        return $result;
    }
}

?>