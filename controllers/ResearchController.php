<?php

require_once __DIR__ . "/../models/Research.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class ResearchController
{
    private $researchModel;
    private $activityLog;


    public function __construct()
    {
        $this->researchModel = new Research();
        $this->activityLog = new ActivityLogController();
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
        $result = $this->researchModel->createOpportunity(
            $title,
            $description,
            $category_id,
            $supervisor_id,
            $department_id,
            $required_skills,
            $max_members,
            $deadline
        );


        if($result)
        {
            $this->activityLog->log(
                $supervisor_id,
                "Created research opportunity: " . $title
            );
        }


        return $result;
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
        $result = $this->researchModel->updateOpportunity(
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


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Updated research opportunity ID: " . $id .
                " - " . $title
            );
        }


        return $result;
    }


    // Delete opportunity
    public function deleteOpportunity($id)
    {
        $result = $this->researchModel->deleteOpportunity(
            $id
        );


        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted research opportunity ID: " . $id
            );
        }


        return $result;
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