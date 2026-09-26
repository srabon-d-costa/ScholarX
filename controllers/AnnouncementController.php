<?php

require_once __DIR__ . "/../models/Announcement.php";
require_once __DIR__ . "/../controllers/ActivityLogController.php";


class AnnouncementController
{
    private $announcementModel;
    private $activityLog;


    public function __construct()
    {
        $this->announcementModel = new Announcement();
        $this->activityLog = new ActivityLogController();
    }


    // Get all announcements
    public function announcements()
    {
        return $this->announcementModel->getAllAnnouncements();
    }


    // Get announcement details
    public function announcementDetails($id)
    {
        return $this->announcementModel->getAnnouncementById($id);
    }


    // Create announcement
    public function createAnnouncement(
        $title,
        $content,
        $created_by,
        $target_role,
        $target_department
    )
    {
        $result = $this->announcementModel->createAnnouncement(
            $title,
            $content,
            $created_by,
            $target_role,
            $target_department
        );


        if($result)
        {
            $this->activityLog->log(
                $created_by,
                "Created announcement: " . $title
            );
        }


        return $result;
    }


    // Update announcement
    public function updateAnnouncement(
        $id,
        $title,
        $content,
        $target_role,
        $target_department
    )
    {
        $result = $this->announcementModel->updateAnnouncement(
            $id,
            $title,
            $content,
            $target_role,
            $target_department
        );


        if($result && isset($_SESSION['user_id']))
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Updated announcement ID: " . $id
            );
        }


        return $result;
    }


    // Activate / deactivate announcement
    public function updateStatus(
        $id,
        $is_active
    )
    {
        $result = $this->announcementModel->updateStatus(
            $id,
            $is_active
        );


        if($result && isset($_SESSION['user_id']))
        {
            $status = $is_active ? "activated" : "deactivated";

            $this->activityLog->log(
                $_SESSION['user_id'],
                ucfirst($status) .
                " announcement ID: " .
                $id
            );
        }


        return $result;
    }


    // Delete announcement
    public function deleteAnnouncement($id)
    {
        $result = $this->announcementModel->deleteAnnouncement(
            $id
        );


        if($result && isset($_SESSION['user_id']))
        {
            $this->activityLog->log(
                $_SESSION['user_id'],
                "Deleted announcement ID: " . $id
            );
        }


        return $result;
    }


    // Get announcements for student
    public function studentAnnouncements($student_id)
    {
        return $this->announcementModel->getStudentAnnouncements(
            $student_id
        );
    }
}

?>