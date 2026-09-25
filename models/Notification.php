<?php

require_once __DIR__ . "/../config/database.php";

class Notification
{
    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }



    // Create notification for one user
    public function createNotification(
        $user_id,
        $type,
        $reference_id,
        $message
    )
    {
        $query = "
            INSERT INTO notifications
            (
                user_id,
                type,
                reference_id,
                message,
                is_read
            )
            VALUES
            (
                ?, ?, ?, ?, 0
            )
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $user_id,
            $type,
            $reference_id,
            $message
        ]);
    }



    // Create notification for multiple users
    public function createBulkNotifications(
        $user_ids,
        $type,
        $reference_id,
        $message
    )
    {
        if (empty($user_ids)) {
            return true;
        }


        $query = "
            INSERT INTO notifications
            (
                user_id,
                type,
                reference_id,
                message,
                is_read
            )
            VALUES
            (
                ?, ?, ?, ?, 0
            )
        ";


        $stmt = $this->db->prepare($query);


        foreach ($user_ids as $user_id) {

            $stmt->execute([
                $user_id,
                $type,
                $reference_id,
                $message
            ]);

        }


        return true;
    }



    // Get all notifications for a user
    public function getUserNotifications($user_id)
    {
        $query = "
            SELECT *
            FROM notifications
            WHERE user_id = ?
            ORDER BY created_at DESC
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $user_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Get unread notifications
    public function getUnreadNotifications($user_id)
    {
        $query = "
            SELECT *
            FROM notifications
            WHERE user_id = ?
            AND is_read = 0
            ORDER BY created_at DESC
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $user_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Count unread notifications
    public function countUnread($user_id)
    {
        $query = "
            SELECT COUNT(*) AS total
            FROM notifications
            WHERE user_id = ?
            AND is_read = 0
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $user_id
        ]);


        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result['total'];
    }



    // Mark one notification as read
    public function markAsRead(
        $id,
        $user_id
    )
    {
        $query = "
            UPDATE notifications
            SET is_read = 1
            WHERE id = ?
            AND user_id = ?
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $id,
            $user_id
        ]);
    }



    // Mark all notifications as read
    public function markAllAsRead($user_id)
    {
        $query = "
            UPDATE notifications
            SET is_read = 1
            WHERE user_id = ?
            AND is_read = 0
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $user_id
        ]);
    }



    // Get one notification
    public function getNotificationById(
        $id,
        $user_id
    )
    {
        $query = "
            SELECT *
            FROM notifications
            WHERE id = ?
            AND user_id = ?
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $id,
            $user_id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Delete notification
    public function deleteNotification(
        $id,
        $user_id
    )
    {
        $query = "
            DELETE FROM notifications
            WHERE id = ?
            AND user_id = ?
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $id,
            $user_id
        ]);
    }
}

?>