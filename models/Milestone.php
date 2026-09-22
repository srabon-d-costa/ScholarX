<?php

require_once __DIR__ . "/../config/database.php";


class Milestone
{

    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }





    // Create milestone
    public function createMilestone(
        $project_id,
        $title,
        $description,
        $due_date
    )
    {

        $query = "

        INSERT INTO milestones
        (
            project_id,
            title,
            description,
            due_date
        )

        VALUES
        (
            ?,?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $project_id,
            $title,
            $description,
            $due_date

        ]);

    }





    // Get milestones by project
    public function getProjectMilestones($project_id)
    {

        $query = "

        SELECT *

        FROM milestones

        WHERE project_id = ?

        ORDER BY due_date ASC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $project_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    // Get single milestone
    public function getMilestoneById($id)
    {

        $query = "

        SELECT *

        FROM milestones

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $id

        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }





    // Update milestone status
    public function updateMilestoneStatus(
        $id,
        $status
    )
    {

        $query = "

        UPDATE milestones

        SET status = ?

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $status,
            $id

        ]);

    }





    // Update milestone progress
    public function updateProgress(
        $id,
        $progress
    )
    {

        /*
        Your current milestones table does NOT
        have a progress column.

        So this function is intentionally not
        updating progress yet.
        */

        return false;

    }





    // Delete milestone
    public function deleteMilestone($id)
    {

        $query = "

        DELETE FROM milestones

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $id

        ]);

    }


}

?>