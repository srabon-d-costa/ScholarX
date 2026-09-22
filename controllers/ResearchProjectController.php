<?php

require_once __DIR__ . "/../models/ResearchProject.php";

class ResearchProjectController
{
    private $projectModel;

    public function __construct()
    {
        $this->projectModel = new ResearchProject();
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
        return $this->projectModel->createProject(
            $proposal_id,
            $title,
            $description,
            $supervisor_id,
            $start_date,
            $end_date
        );
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
        return $this->projectModel->getProjectById($id);
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
        return $this->projectModel->updateProgress(
            $id,
            $progress
        );
    }

    // Update project status
    public function updateStatus(
        $id,
        $status
    )
    {
        return $this->projectModel->updateStatus(
            $id,
            $status
        );
    }

    // Delete project
    public function deleteProject($id)
    {
        return $this->projectModel->deleteProject($id);
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