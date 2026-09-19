<?php

require_once __DIR__ . "/../models/Application.php";


class ApplicationController
{

    private $applicationModel;


    public function __construct()
    {
        $this->applicationModel = new Application();
    }




    // Submit application
    public function apply(
        $opportunity_id,
        $student_id,
        $message
    )
    {

        return $this->applicationModel->createApplication(
            $opportunity_id,
            $student_id,
            $message
        );

    }




    // Check existing application
    public function alreadyApplied(
        $opportunity_id,
        $student_id
    )
    {

        return $this->applicationModel->checkApplication(
            $opportunity_id,
            $student_id
        );

    }




    // Get student applications
    public function myApplications($student_id)
    {

        return $this->applicationModel->getStudentApplications(
            $student_id
        );

    }




    // Get applications for supervisor
    public function applications($supervisor_id)
    {

        return $this->applicationModel->getApplicationsBySupervisor(
            $supervisor_id
        );

    }




    // Accept / Reject application
    public function changeStatus(
        $application_id,
        $status
    )
    {

        return $this->applicationModel->updateApplicationStatus(
            $application_id,
            $status
        );

    }


}

?>