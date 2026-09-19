<?php

require_once __DIR__ . "/../config/database.php";


class Feedback
{

    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }





    // Create feedback
    public function createFeedback(
        $project_id,
        $from_user_id,
        $to_user_id,
        $message,
        $rating
    )
    {

        $query = "

        INSERT INTO feedback
        (
            project_id,
            from_user_id,
            to_user_id,
            message,
            rating
        )

        VALUES
        (
            ?,?,?,?,?
        )

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $project_id,
            $from_user_id,
            $to_user_id,
            $message,
            $rating

        ]);

    }






    // Get feedback given by supervisor
    public function getSupervisorFeedback($user_id)
    {

        $query = "

        SELECT

        feedback.*,

        users.name AS student_name


        FROM feedback


        LEFT JOIN users

        ON feedback.to_user_id = users.id


        WHERE feedback.from_user_id = ?


        ORDER BY feedback.created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $user_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }







    // Get feedback received by student
    public function getStudentFeedback($student_id)
    {

        $query = "

        SELECT

        feedback.*,

        users.name AS supervisor_name


        FROM feedback


        LEFT JOIN users

        ON feedback.from_user_id = users.id


        WHERE feedback.to_user_id = ?


        ORDER BY feedback.created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $student_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }







    // Get feedback by project
    public function getProjectFeedback($project_id)
    {

        $query = "

        SELECT

        feedback.*,

        u1.name AS supervisor_name,

        u2.name AS student_name


        FROM feedback


        LEFT JOIN users u1

        ON feedback.from_user_id = u1.id


        LEFT JOIN users u2

        ON feedback.to_user_id = u2.id


        WHERE feedback.project_id = ?


        ORDER BY feedback.created_at DESC

        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([

            $project_id

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    // Delete feedback
    public function deleteFeedback($id)
    {

        $query = "

        DELETE FROM feedback

        WHERE id = ?

        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([

            $id

        ]);

    }


}

?>