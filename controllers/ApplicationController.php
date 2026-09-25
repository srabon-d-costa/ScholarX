<?php

require_once __DIR__ . "/../models/Application.php";
require_once __DIR__ . "/../controllers/NotificationController.php";

class ApplicationController
{
    private $applicationModel;
    private $notification;


    public function __construct()
    {
        $this->applicationModel = new Application();
        $this->notification = new NotificationController();
    }


    // Submit application
    public function apply(
        $opportunity_id,
        $student_id,
        $message
    )
    {
        // Create application
        $application_id = $this->applicationModel->createApplication(
            $opportunity_id,
            $student_id,
            $message
        );


        // Application failed
        if(!$application_id)
        {
            return false;
        }


        // Get opportunity supervisor
        $opportunity = $this->applicationModel->getOpportunitySupervisor(
            $opportunity_id
        );


        if($opportunity)
        {
            $supervisor_id = $opportunity['supervisor_id'];

            $student_name = $this->applicationModel->getStudentName(
                $student_id
            );


            // Create supervisor notification
            $this->notification->createNotification(
                $supervisor_id,
                "application",
                $application_id,
                $student_name .
                " applied for your research opportunity: " .
                $opportunity['title']
            );
        }


        return $application_id;
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