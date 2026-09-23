<?php

require_once __DIR__ . "/../config/database.php";

class Announcement
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all announcements
    public function getAllAnnouncements()
    {
        $query = "
            SELECT
                announcements.*,
                users.name AS creator_name
            FROM announcements
            LEFT JOIN users
                ON announcements.created_by = users.id
            ORDER BY announcements.created_at DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single announcement
    public function getAnnouncementById($id)
    {
        $query = "
            SELECT *
            FROM announcements
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $query = "
            INSERT INTO announcements
            (
                title,
                content,
                created_by,
                target_role,
                target_department,
                is_active
            )
            VALUES
            (
                ?, ?, ?, ?, ?, 1
            )
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $title,
            $content,
            $created_by,
            $target_role,
            $target_department
        ]);
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
        $query = "
            UPDATE announcements
            SET
                title = ?,
                content = ?,
                target_role = ?,
                target_department = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $title,
            $content,
            $target_role,
            $target_department,
            $id
        ]);
    }

    // Activate / deactivate announcement
    public function updateStatus($id, $is_active)
    {
        $query = "
            UPDATE announcements
            SET is_active = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $is_active,
            $id
        ]);
    }

    // Delete announcement
    public function deleteAnnouncement($id)
    {
        $query = "
            DELETE FROM announcements
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $id
        ]);
    }
}
?>