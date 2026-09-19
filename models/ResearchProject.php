<?php

require_once __DIR__ . "/../config/database.php";


class ResearchProject
{

    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }





    // Create research project
    public function createProject(
        $proposal_id,
        $title,
        $description,
        $supervisor_id,
        $start_date,
        $end_date
    )
    {

        $query = "

        INSERT INTO research_projects
        (
            proposal_id,
            title,
            description,
            supervisor_id,
            start_date,
            end_date
        )

        VALUES
        (
            ?,?,?,?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $proposal_id,
            $title,
            $description,
            $supervisor_id,
            $start_date,
            $end_date

        ]);

    }





    // Get supervisor projects
    public function getSupervisorProjects($supervisor_id)
    {

        $query = "

        SELECT *

        FROM research_projects

        WHERE supervisor_id = ?

        ORDER BY created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $supervisor_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    // Get single project
    public function getProjectById($id)
    {

        $query = "

        SELECT *

        FROM research_projects

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $id

        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }





    // Update project progress
    public function updateProgress(
        $id,
        $progress
    )
    {

        $query = "

        UPDATE research_projects

        SET progress = ?

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $progress,
            $id

        ]);

    }





    // Update project status
    public function updateStatus(
        $id,
        $status
    )
    {

        $query = "

        UPDATE research_projects

        SET status = ?

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $status,
            $id

        ]);

    }





    // Delete project
    public function deleteProject($id)
    {

        $query = "

        DELETE FROM research_projects

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $id

        ]);

    }





    // Get all projects
    public function getAllProjects()
    {

        $query = "

        SELECT *

        FROM research_projects

        ORDER BY created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}

?>