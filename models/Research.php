<?php

require_once __DIR__ . "/../config/database.php";


class Research
{

    private $db;



    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }





    // Get all research opportunities
    public function getAllOpportunities()
    {

        $query = "

        SELECT
            research_opportunities.*,

            users.name AS supervisor_name,

            departments.name AS department_name


        FROM research_opportunities


        LEFT JOIN users
        ON research_opportunities.supervisor_id = users.id


        LEFT JOIN departments
        ON research_opportunities.department_id = departments.id


        ORDER BY created_at DESC

        ";


        $stmt = $this->db->prepare($query);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }







    // Get single research opportunity
    public function getOpportunityById($id)
    {

        $query = "

        SELECT
            research_opportunities.*,

            users.name AS supervisor_name,

            departments.name AS department_name


        FROM research_opportunities


        LEFT JOIN users
        ON research_opportunities.supervisor_id = users.id


        LEFT JOIN departments
        ON research_opportunities.department_id = departments.id


        WHERE research_opportunities.id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }







    // Create research opportunity
    public function createOpportunity(
        $title,
        $description,
        $category_id,
        $supervisor_id,
        $department_id,
        $required_skills,
        $max_members,
        $deadline
    )
    {

        $query = "

        INSERT INTO research_opportunities
        (
            title,
            description,
            category_id,
            supervisor_id,
            department_id,
            required_skills,
            max_members,
            deadline
        )

        VALUES
        (
            ?,?,?,?,?,?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $title,

            $description,

            $category_id,

            $supervisor_id,

            $department_id,

            $required_skills,

            $max_members,

            $deadline

        ]);

    }








    // Update research opportunity
    public function updateOpportunity(
        $id,
        $title,
        $description,
        $category_id,
        $department_id,
        $required_skills,
        $max_members,
        $deadline,
        $status
    )
    {

        $query = "

        UPDATE research_opportunities

        SET

        title = ?,
        description = ?,
        category_id = ?,
        department_id = ?,
        required_skills = ?,
        max_members = ?,
        deadline = ?,
        status = ?

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $title,

            $description,

            $category_id,

            $department_id,

            $required_skills,

            $max_members,

            $deadline,

            $status,

            $id

        ]);

    }








    // Delete research opportunity
    public function deleteOpportunity($id)
    {

        $query = "

        DELETE FROM research_opportunities

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $id

        ]);

    }








    // Get all research categories
    public function getCategories()
    {

        $query = "

        SELECT
            id,
            name

        FROM research_categories

        ORDER BY name ASC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }








    // Get all departments
    public function getDepartments()
    {

        $query = "

        SELECT
            id,
            name

        FROM departments

        ORDER BY name ASC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}

?>