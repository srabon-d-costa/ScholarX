<?php

require_once __DIR__ . "/../models/Proposal.php";


class ProposalController
{

    private $proposalModel;



    public function __construct()
    {
        $this->proposalModel = new Proposal();
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

        return $this->proposalModel->createProposal(

            $opportunity_id,
            $team_id,
            $title,
            $abstract,
            $file_path

        );

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

        return $this->proposalModel->updateStatus(

            $id,
            $status

        );

    }





    // Approved proposals for project creation
    public function approvedProposals()
    {

        return $this->proposalModel->getApprovedProposals();

    }


}

?>