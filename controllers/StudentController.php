<?php

require_once __DIR__ . "/../models/Student.php";

class StudentController
{

    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    // Get all open research opportunities
    public function opportunities()
    {
        return $this->studentModel->getOpenOpportunities();
    }

    // Get single opportunity details
    public function opportunityDetails($id)
    {
        return $this->studentModel->getOpportunityById($id);
    }

}

?>