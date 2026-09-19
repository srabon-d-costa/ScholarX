<?php

require_once __DIR__ . "/../config/database.php";


class Student
{

    private $db;



    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }






    // Get all open research opportunities
    public function getOpenOpportunities()
    {

        $query = "

        SELECT

            research_opportunities.*,

            users.name AS supervisor_name,

            departments.name AS department_name,

            research_categories.name AS category_name


        FROM research_opportunities


        LEFT JOIN users
        ON research_opportunities.supervisor_id = users.id


        LEFT JOIN departments
        ON research_opportunities.department_id = departments.id


        LEFT JOIN research_categories
        ON research_opportunities.category_id = research_categories.id


        WHERE research_opportunities.status = 'Open'


        ORDER BY research_opportunities.created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }








    // Get single opportunity details
    public function getOpportunityById($id)
    {

        $query = "

        SELECT

            research_opportunities.*,

            users.name AS supervisor_name,

            departments.name AS department_name,

            research_categories.name AS category_name


        FROM research_opportunities


        LEFT JOIN users
        ON research_opportunities.supervisor_id = users.id


        LEFT JOIN departments
        ON research_opportunities.department_id = departments.id


        LEFT JOIN research_categories
        ON research_opportunities.category_id = research_categories.id


        WHERE research_opportunities.id = ?

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }


}

?>