<?php

require_once __DIR__ . "/../models/Feedback.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class FeedbackController
{
    private $feedbackModel;
    private $activityLog;


    public function __construct()
    {
        $this->feedbackModel = new Feedback();
        $this->activityLog = new ActivityLogController();
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
        $result = $this->feedbackModel->createFeedback(
            $project_id,
            $from_user_id,
            $to_user_id,
            $message,
            $rating
        );


        // Create activity log after successful feedback
        if($result)
        {
            $this->activityLog->log(
                $from_user_id,
                "Gave feedback to user ID: " .
                $to_user_id .
                " for project ID: " .
                $project_id
            );
        }


        return $result;
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
        $result = $this->feedbackModel->deleteFeedback(
            $id
        );


        // Create activity log after successful deletion
        if($result)
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted feedback ID: " .
                $id
            );
        }


        return $result;
    }
}

?>