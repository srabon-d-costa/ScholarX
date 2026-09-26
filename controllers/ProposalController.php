<?php

require_once __DIR__ . "/../models/Proposal.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class ProposalController
{
    private $proposalModel;
    private $activityLog;


    public function __construct()
    {
        $this->proposalModel = new Proposal();
        $this->activityLog = new ActivityLogController();
    }


    // Student submit proposal
    public function createProposal(
        $opportunity_id,
        $team_id,
        $title,
        $abstract,
        $file_path
    )
    {
        $result = $this->proposalModel->createProposal(
            $opportunity_id,
            $team_id,
            $title,
            $abstract,
            $file_path
        );


        // Create activity log after successful submission
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Submitted research proposal: " . $title
            );
        }


        return $result;
    }


    // Get proposals of a team/student
    public function studentProposals($team_id)
    {
        return $this->proposalModel->getStudentProposals(
            $team_id
        );
    }


    // Supervisor view proposals
    public function supervisorProposals($supervisor_id)
    {
        return $this->proposalModel->getSupervisorProposals(
            $supervisor_id
        );
    }


    // Approve / reject proposal
    public function updateStatus(
        $id,
        $status
    )
    {
        $result = $this->proposalModel->updateStatus(
            $id,
            $status
        );


        // Create activity log after successful status update
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                $status . " research proposal ID: " . $id
            );
        }


        return $result;
    }


    // Approved proposals for project creation
    public function approvedProposals()
    {
        return $this->proposalModel->getApprovedProposals();
    }
}

?>