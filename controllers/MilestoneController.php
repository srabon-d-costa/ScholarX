<?php

require_once __DIR__ . "/../models/Milestone.php";


class MilestoneController
{

    private $milestoneModel;



    public function __construct()
    {
        $this->milestoneModel = new Milestone();
    }





    // Create milestone
    public function createMilestone(
        $project_id,
        $title,
        $description,
        $deadline
    )
    {

        return $this->milestoneModel->createMilestone(

            $project_id,
            $title,
            $description,
            $deadline

        );

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

        return $this->milestoneModel->updateMilestoneStatus(

            $id,
            $status

        );

    }





    // Update milestone progress
    public function updateProgress(
        $id,
        $progress
    )
    {

        return $this->milestoneModel->updateProgress(

            $id,
            $progress

        );

    }





    // Delete milestone
    public function deleteMilestone($id)
    {

        return $this->milestoneModel->deleteMilestone(

            $id

        );

    }


}

?>