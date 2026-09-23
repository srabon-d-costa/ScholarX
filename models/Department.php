<?php

require_once __DIR__ . "/../config/database.php";

class Department
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all departments
    public function getAllDepartments()
    {
        $query = "
            SELECT *
            FROM departments
            ORDER BY name ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single department
    public function getDepartmentById($id)
    {
        $query = "
            SELECT *
            FROM departments
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create department
    public function createDepartment(
        $name,
        $code,
        $description
    )
    {
        $query = "
            INSERT INTO departments
            (
                name,
                code,
                description
            )
            VALUES
            (
                ?, ?, ?
            )
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $name,
            $code,
            $description
        ]);
    }

    // Update department
    public function updateDepartment(
        $id,
        $name,
        $code,
        $description
    )
    {
        $query = "
            UPDATE departments
            SET
                name = ?,
                code = ?,
                description = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $name,
            $code,
            $description,
            $id
        ]);
    }

    // Delete department
    public function deleteDepartment($id)
    {
        $query = "
            DELETE FROM departments
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $id
        ]);
    }
}
?>