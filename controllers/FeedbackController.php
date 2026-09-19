<?php

require_once __DIR__ . "/../models/Feedback.php";


class FeedbackController
{

    private $feedbackModel;



    public function __construct()
    {
        $this->feedbackModel = new Feedback();
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

        return $this->feedbackModel->createFeedback(

            $project_id,
            $from_user_id,
            $to_user_id,
            $message,
            $rating

        );

    }





    // Supervisor feedback list
    public function supervisorFeedback($user_id)
    {

        return $this->feedbackModel->getSupervisorFeedback(

            $user_id

        );

    }





    // Student received feedback
    public function studentFeedback($student_id)
    {

        return $this->feedbackModel->getStudentFeedback(

            $student_id

        );

    }





    // Project feedback
    public function projectFeedback($project_id)
    {

        return $this->feedbackModel->getProjectFeedback(

            $project_id

        );

    }





    // Delete feedback
    public function deleteFeedback($id)
    {

        return $this->feedbackModel->deleteFeedback(

            $id

        );

    }


}

?>