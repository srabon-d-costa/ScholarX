<?php

require_once __DIR__ . "/../models/Team.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class TeamController
{
    private $teamModel;
    private $activityLog;


    public function __construct()
    {
        $this->teamModel = new Team();
        $this->activityLog = new ActivityLogController();
    }


    // Create research team
    public function createTeam(
        $name,
        $description,
        $created_by
    )
    {
        $result = $this->teamModel->createTeam(
            $name,
            $description,
            $created_by
        );


        // Log successful team creation
        if($result)
        {
            $this->activityLog->log(
                $created_by,
                "Created research team: " . $name
            );
        }


        return $result;
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
        $result = $this->teamModel->addMember(
            $team_id,
            $user_id
        );


        // Log successful member addition
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Added user ID " .
                $user_id .
                " to research team ID " .
                $team_id
            );
        }


        return $result;
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
        $result = $this->teamModel->removeMember(
            $id
        );


        // Log successful member removal
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Removed team member record ID: " .
                $id
            );
        }


        return $result;
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