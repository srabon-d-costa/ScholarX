<?php

require_once __DIR__ . "/../models/ResearchProject.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class ResearchProjectController
{
    private $projectModel;
    private $activityLog;


    public function __construct()
    {
        $this->projectModel = new ResearchProject();
        $this->activityLog = new ActivityLogController();
    }


    // Create new research project
    public function createProject(
        $proposal_id,
        $title,
        $description,
        $supervisor_id,
        $start_date,
        $end_date
    )
    {
        $result = $this->projectModel->createProject(
            $proposal_id,
            $title,
            $description,
            $supervisor_id,
            $start_date,
            $end_date
        );


        // Create activity log after successful creation
        if($result)
        {
            $this->activityLog->log(
                $supervisor_id,
                "Created research project: " . $title
            );
        }


        return $result;
    }


    // Get supervisor projects
    public function projects($supervisor_id)
    {
        return $this->projectModel->getSupervisorProjects(
            $supervisor_id
        );
    }


    // Get project details
    public function projectDetails($id)
    {
        return $this->projectModel->getProjectById(
            $id
        );
    }


    // Calculate project progress from milestones
    public function calculateProgress($project_id)
    {
        return $this->projectModel->calculateProjectProgress(
            $project_id
        );
    }


    // Update project progress
    public function updateProgress(
        $id,
        $progress
    )
    {
        $result = $this->projectModel->updateProgress(
            $id,
            $progress
        );


        // Create activity log after successful update
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Updated research project ID: " .
                $id .
                " progress to " .
                $progress .
                "%"
            );
        }


        return $result;
    }


    // Update project status
    public function updateStatus(
        $id,
        $status
    )
    {
        $result = $this->projectModel->updateStatus(
            $id,
            $status
        );


        // Create activity log after successful update
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Changed research project ID: " .
                $id .
                " status to " .
                $status
            );
        }


        return $result;
    }


    // Delete project
    public function deleteProject($id)
    {
        $result = $this->projectModel->deleteProject(
            $id
        );


        // Create activity log after successful deletion
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted research project ID: " .
                $id
            );
        }


        return $result;
    }


    // Get all projects
    public function allProjects()
    {
        return $this->projectModel->getAllProjects();
    }


    // Get student research projects
    public function studentProjects($student_id)
    {
        return $this->projectModel->getStudentProjects(
            $student_id
        );
    }
}

?>