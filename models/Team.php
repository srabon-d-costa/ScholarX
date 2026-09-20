<?php

require_once __DIR__ . "/../config/database.php";


class Team
{

    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }



    // Create research team
    public function createTeam(
        $name,
        $description,
        $created_by
    )
    {

        $query = "

        INSERT INTO research_teams
        (
            name,
            description,
            created_by
        )

        VALUES
        (
            ?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $name,
            $description,
            $created_by
        ]);

    }





    // Get teams created by supervisor
    public function getSupervisorTeams($created_by)
    {

        $query = "

        SELECT *

        FROM research_teams

        WHERE created_by = ?

        ORDER BY created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $created_by
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    // Get single team details
    public function getTeamById($id)
    {

        $query = "

        SELECT *

        FROM research_teams

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }





    // Add member to team
    public function addMember(
        $team_id,
        $user_id
    )
    {

        // Check duplicate member

        $checkQuery = "

        SELECT *

        FROM team_members

        WHERE team_id = ?

        AND user_id = ?

        ";


        $checkStmt = $this->db->prepare($checkQuery);


        $checkStmt->execute([
            $team_id,
            $user_id
        ]);



        if($checkStmt->fetch())
        {
            return false;
        }





        // Insert new member

        $query = "

        INSERT INTO team_members
        (
            team_id,
            user_id
        )

        VALUES
        (
            ?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $team_id,
            $user_id
        ]);

    }





    // Get team members
    public function getMembers($team_id)
    {

        $query = "

        SELECT

        team_members.*,

        users.name AS student_name,

        users.email


        FROM team_members


        LEFT JOIN users

        ON team_members.user_id = users.id


        WHERE team_members.team_id = ?


        ORDER BY team_members.joined_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $team_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    // Remove member
    public function removeMember($id)
    {

        $query = "

        DELETE FROM team_members

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $id
        ]);

    }





    // Check duplicate member
    public function checkMember(
        $team_id,
        $user_id
    )
    {

        $query = "

        SELECT *

        FROM team_members

        WHERE team_id = ?

        AND user_id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $team_id,
            $user_id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }





    // Get available students
    public function getStudents()
    {

        $query = "

        SELECT

        id,
        name,
        email

        FROM users

        WHERE role_id = 2

        ORDER BY name ASC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    // Get teams of a student
    public function getStudentTeams($student_id)
    {

        $query = "

        SELECT

        research_teams.*

        FROM research_teams
        INNER JOIN team_members
        ON research_teams.id = team_members.team_id
        WHERE team_members.user_id = ?
        ORDER BY research_teams.created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $student_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}

?>