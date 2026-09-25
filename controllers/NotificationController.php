<?php

require_once __DIR__ . "/../models/Notification.php";

class NotificationController
{
    private $notificationModel;


    public function __construct()
    {
        $this->notificationModel = new Notification();
    }


    // Create notification for one user
    public function createNotification(
        $user_id,
        $type,
        $reference_id,
        $message
    )
    {
        return $this->notificationModel->createNotification(
            $user_id,
            $type,
            $reference_id,
            $message
        );
    }


    // Create notification for multiple users
    public function createBulkNotifications(
        $user_ids,
        $type,
        $reference_id,
        $message
    )
    {
        return $this->notificationModel->createBulkNotifications(
            $user_ids,
            $type,
            $reference_id,
            $message
        );
    }


    // Get all notifications for a user
    public function userNotifications($user_id)
    {
        return $this->notificationModel->getUserNotifications(
            $user_id
        );
    }


    // Get unread notifications
    public function unreadNotifications($user_id)
    {
        return $this->notificationModel->getUnreadNotifications(
            $user_id
        );
    }


    // Count unread notifications
    public function unreadCount($user_id)
    {
        return $this->notificationModel->countUnread(
            $user_id
        );
    }


    // Get one notification
    public function notificationDetails(
        $id,
        $user_id
    )
    {
        return $this->notificationModel->getNotificationById(
            $id,
            $user_id
        );
    }


    // Mark one notification as read
    public function markAsRead(
        $id,
        $user_id
    )
    {
        return $this->notificationModel->markAsRead(
            $id,
            $user_id
        );
    }


    // Mark all notifications as read
    public function markAllAsRead($user_id)
    {
        return $this->notificationModel->markAllAsRead(
            $user_id
        );
    }


    // Delete notification
    public function deleteNotification(
        $id,
        $user_id
    )
    {
        return $this->notificationModel->deleteNotification(
            $id,
            $user_id
        );
    }
}

?>