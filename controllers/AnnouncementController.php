<?php

require_once __DIR__ . "/../models/Announcement.php";

class AnnouncementController
{
    private $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new Announcement();
    }


    // Get all announcements
    public function announcements()
    {
        return $this->announcementModel->getAllAnnouncements();
    }


    // Get announcement details
    public function announcementDetails($id)
    {
        return $this->announcementModel->getAnnouncementById(
            $id
        );
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
        return $this->announcementModel->createAnnouncement(
            $title,
            $content,
            $created_by,
            $target_role,
            $target_department
        );
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
        return $this->announcementModel->updateAnnouncement(
            $id,
            $title,
            $content,
            $target_role,
            $target_department
        );
    }


    // Update active status
    public function updateStatus(
        $id,
        $is_active
    )
    {
        return $this->announcementModel->updateStatus(
            $id,
            $is_active
        );
    }


    // Delete announcement
    public function deleteAnnouncement($id)
    {
        return $this->announcementModel->deleteAnnouncement(
            $id
        );
    }


    // Get announcements for student
    public function studentAnnouncements($student_id)
    {
        return $this->announcementModel->getStudentAnnouncements(
            $student_id
        );
    }


    // Get students who should receive an announcement
    public function announcementRecipients(
        $target_role,
        $target_department
    )
    {
        return $this->announcementModel->getAnnouncementRecipients(
            $target_role,
            $target_department
        );
    }
}

?>