<?php

require_once __DIR__ . "/../config/database.php";

class ActivityLog
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }


    // Create activity log
    public function createLog($user_id, $action, $ip_address)
    {
        $query = "
            INSERT INTO activity_logs
            (
                user_id,
                action,
                ip_address
            )
            VALUES
            (
                ?, ?, ?
            )
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $user_id,
            $action,
            $ip_address
        ]);
    }


    // Get all activity logs
    public function getAllLogs()
    {
        $query = "
            SELECT
                activity_logs.*,
                users.name AS user_name,
                users.email AS user_email
            FROM activity_logs

            LEFT JOIN users
                ON activity_logs.user_id = users.id

            ORDER BY activity_logs.created_at DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Get logs for a specific user
    public function getUserLogs($user_id)
    {
        $query = "
            SELECT *
            FROM activity_logs
            WHERE user_id = ?
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $user_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>