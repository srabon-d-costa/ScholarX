<?php

require_once __DIR__ . "/../models/Team.php";

class TeamController
{
    private $teamModel;

    public function __construct()
    {
        $this->teamModel = new Team();
    }

    // Create research team
    public function createTeam(
        $name,
        $description,
        $created_by
    )
    {
        return $this->teamModel->createTeam(
            $name,
            $description,
            $created_by
        );
    }

    // Get teams created by supervisor
    public function teams($created_by)
    {
        return $this->teamModel->getSupervisorTeams(
            $created_by
        );
    }

    // Get single team
    public function teamDetails($id)
    {
        return $this->teamModel->getTeamById(
            $id
        );
    }

    // Add student member
    public function addMember(
        $team_id,
        $user_id
    )
    {
        return $this->teamModel->addMember(
            $team_id,
            $user_id
        );
    }

    // Get team members
    public function members($team_id)
    {
        return $this->teamModel->getMembers(
            $team_id
        );
    }

    // Remove member
    public function removeMember($id)
    {
        return $this->teamModel->removeMember(
            $id
        );
    }

    // Check member
    public function checkMember(
        $team_id,
        $user_id
    )
    {
        return $this->teamModel->checkMember(
            $team_id,
            $user_id
        );
    }

    // Get available students
    public function students()
    {
        return $this->teamModel->getStudents();
    }

    // Get teams belonging to student
    public function studentTeams($student_id)
    {
        return $this->teamModel->getStudentTeams(
            $student_id
        );
    }
}
?>