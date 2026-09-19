<?php

require_once __DIR__ . "/../models/Team.php";


class TeamController
{

    private $teamModel;



    public function __construct()
    {
        $this->teamModel = new Team();
    }





    // Create new research team
    public function createTeam(
        $project_id,
        $team_name,
        $supervisor_id
    )
    {

        return $this->teamModel->createTeam(
            $project_id,
            $team_name,
            $supervisor_id
        );

    }





    // Get supervisor teams
    public function teams($supervisor_id)
    {

        return $this->teamModel->getSupervisorTeams(
            $supervisor_id
        );

    }





    // Get team details
    public function teamDetails($team_id)
    {

        return $this->teamModel->getTeamById(
            $team_id
        );

    }





    // Add student member
    public function addMember(
        $team_id,
        $student_id
    )
    {

        return $this->teamModel->addMember(
            $team_id,
            $student_id
        );

    }





    // Get team members
    public function members($team_id)
    {

        return $this->teamModel->getMembers(
            $team_id
        );

    }





    // Remove team member
    public function removeMember($member_id)
    {

        return $this->teamModel->removeMember(
            $member_id
        );

    }

    // Get students
    public function students()
    {

        return $this->teamModel->getStudents();

    }



}

?>