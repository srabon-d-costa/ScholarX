<?php

require_once __DIR__ . "/../config/database.php";

class Application
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }


    // Student applies for opportunity
    public function createApplication(
        $opportunity_id,
        $student_id,
        $message
    )
    {
        $query = "
            INSERT INTO opportunity_applications
            (
                opportunity_id,
                student_id,
                message
            )
            VALUES
            (
                ?, ?, ?
            )
        ";

        $stmt = $this->db->prepare($query);

        $result = $stmt->execute([
            $opportunity_id,
            $student_id,
            $message
        ]);

        if($result)
        {
            return $this->db->lastInsertId();
        }

        return false;
    }


    // Get supervisor of an opportunity
    public function getOpportunitySupervisor($opportunity_id)
    {
        $query = "
            SELECT
                supervisor_id,
                title
            FROM research_opportunities
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $opportunity_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Get student name
    public function getStudentName($student_id)
    {
        $query = "
            SELECT name
            FROM users
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $student_id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['name'] : 'A student';
    }


    // Check duplicate application
    public function checkApplication(
        $opportunity_id,
        $student_id
    )
    {
        $query = "
            SELECT *
            FROM opportunity_applications
            WHERE opportunity_id = ?
            AND student_id = ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $opportunity_id,
            $student_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Student application list
    public function getStudentApplications($student_id)
    {
        $query = "
            SELECT
                opportunity_applications.*,
                research_opportunities.title
            FROM opportunity_applications
            LEFT JOIN research_opportunities
                ON opportunity_applications.opportunity_id =
                   research_opportunities.id
            WHERE student_id = ?
            ORDER BY applied_at DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $student_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Get applications for supervisor projects
    public function getApplicationsBySupervisor($supervisor_id)
    {
        $query = "
            SELECT
                opportunity_applications.*,
                users.name AS student_name,
                research_opportunities.title AS research_title
            FROM opportunity_applications
            LEFT JOIN users
                ON opportunity_applications.student_id = users.id
            LEFT JOIN research_opportunities
                ON opportunity_applications.opportunity_id =
                   research_opportunities.id
            WHERE research_opportunities.supervisor_id = ?
            ORDER BY opportunity_applications.applied_at DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $supervisor_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Update application status
    public function updateApplicationStatus(
        $application_id,
        $status
    )
    {
        $query = "
            UPDATE opportunity_applications
            SET
                status = ?,
                reviewed_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $status,
            $application_id
        ]);
    }
}

?>