<?php

require_once __DIR__ . "/../config/database.php";


class Proposal
{

    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }





    // Student submits proposal
    public function createProposal(
        $opportunity_id,
        $team_id,
        $title,
        $abstract,
        $file_path
    )
    {

        $query = "

        INSERT INTO proposals
        (
            opportunity_id,
            team_id,
            title,
            abstract,
            file_path,
            status
        )

        VALUES
        (
            ?,?,?,?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $opportunity_id,
            $team_id,
            $title,
            $abstract,
            $file_path,
            "Submitted"

        ]);

    }






    // Student proposals
    public function getStudentProposals($team_id)
    {

        $query = "

        SELECT *

        FROM proposals

        WHERE team_id = ?

        ORDER BY created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $team_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }







    // Supervisor view proposals
    public function getSupervisorProposals($supervisor_id)
    {

        $query = "

        SELECT


        proposals.*,


        research_opportunities.title 
        AS opportunity_title


        FROM proposals



        LEFT JOIN research_opportunities

        ON proposals.opportunity_id = research_opportunities.id



        LEFT JOIN research_teams

        ON proposals.team_id = research_teams.id



        WHERE research_teams.created_by = ?



        ORDER BY proposals.created_at DESC


        ";



        $stmt = $this->db->prepare($query);



        $stmt->execute([

            $supervisor_id

        ]);



        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }








    // Update proposal status
    public function updateStatus(
        $id,
        $status
    )
    {

        $query = "

        UPDATE proposals

        SET

        status = ?

        WHERE id = ?

        ";



        $stmt = $this->db->prepare($query);



        return $stmt->execute([

            $status,

            $id

        ]);

    }








    // Get approved proposals
    // Used for creating research projects
    public function getApprovedProposals()
    {

        $query = "

        SELECT *

        FROM proposals

        WHERE status = 'Approved'

        ORDER BY created_at DESC

        ";



        $stmt = $this->db->prepare($query);



        $stmt->execute();



        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }




}

?>