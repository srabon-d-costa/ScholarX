<?php

require_once __DIR__ . "/../models/Department.php";

class DepartmentController
{
    private $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new Department();
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
        return $this->departmentModel->createDepartment(
            $name,
            $code,
            $description
        );
    }

    // Update department
    public function updateDepartment(
        $id,
        $name,
        $code,
        $description
    )
    {
        return $this->departmentModel->updateDepartment(
            $id,
            $name,
            $code,
            $description
        );
    }

    // Delete department
    public function deleteDepartment($id)
    {
        return $this->departmentModel->deleteDepartment($id);
    }
}
?>