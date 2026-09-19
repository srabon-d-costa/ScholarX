<?php

require_once __DIR__ . "/../models/Research.php";


class ResearchController
{

    private $researchModel;



    public function __construct()
    {
        $this->researchModel = new Research();
    }






    // Get all research opportunities
    public function opportunities()
    {
        return $this->researchModel->getAllOpportunities();
    }






    // Get single opportunity details
    public function opportunityDetails($id)
    {
        return $this->researchModel->getOpportunityById($id);
    }







    // Create new opportunity
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

        return $this->researchModel->createOpportunity(
            $title,
            $description,
            $category_id,
            $supervisor_id,
            $department_id,
            $required_skills,
            $max_members,
            $deadline
        );

    }







    // Update opportunity
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

        return $this->researchModel->updateOpportunity(
            $id,
            $title,
            $description,
            $category_id,
            $department_id,
            $required_skills,
            $max_members,
            $deadline,
            $status
        );

    }







    // Delete opportunity
    public function deleteOpportunity($id)
    {
        return $this->researchModel->deleteOpportunity($id);
    }







    // Get research categories
    public function categories()
    {
        return $this->researchModel->getCategories();
    }







    // Get departments
    public function departments()
    {
        return $this->researchModel->getDepartments();
    }


}

?>