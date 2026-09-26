<?php

require_once __DIR__ . "/../models/Milestone.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class MilestoneController
{
    private $milestoneModel;
    private $activityLog;


    public function __construct()
    {
        $this->milestoneModel = new Milestone();
        $this->activityLog = new ActivityLogController();
    }


    // Create milestone
    public function createMilestone(
        $project_id,
        $title,
        $description,
        $due_date
    )
    {
        $result = $this->milestoneModel->createMilestone(
            $project_id,
            $title,
            $description,
            $due_date
        );


        // Create activity log after successful creation
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Created milestone: " .
                $title .
                " for project ID: " .
                $project_id
            );
        }


        return $result;
    }


    // Get project milestones
    public function milestones($project_id)
    {
        return $this->milestoneModel->getProjectMilestones(
            $project_id
        );
    }


    // Get single milestone
    public function milestoneDetails($id)
    {
        return $this->milestoneModel->getMilestoneById(
            $id
        );
    }


    // Update milestone status
    public function updateStatus(
        $id,
        $status
    )
    {
        $result = $this->milestoneModel->updateMilestoneStatus(
            $id,
            $status
        );


        // Create activity log after successful status update
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Changed milestone ID: " .
                $id .
                " status to " .
                $status
            );
        }


        return $result;
    }


    // Delete milestone
    public function deleteMilestone($id)
    {
        $result = $this->milestoneModel->deleteMilestone(
            $id
        );


        // Create activity log after successful deletion
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted milestone ID: " .
                $id
            );
        }


        return $result;
    }
}

?>