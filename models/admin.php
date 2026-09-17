<?php

require_once __DIR__ . "/../config/database.php";


class Admin
{
    private $db;


    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }



    // Get all users
    public function getAllUsers()
    {
        $query = "
        SELECT
            users.id,
            users.name,
            users.email,
            roles.role_name,
            departments.name AS department,
            users.status,
            users.created_at

        FROM users

        LEFT JOIN roles
        ON users.role_id = roles.id

        LEFT JOIN departments
        ON users.department_id = departments.id

        ORDER BY users.created_at DESC
        ";


        $stmt = $this->db->prepare($query);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Search users
    public function searchUsers($keyword)
    {
        $query = "
        SELECT
            users.id,
            users.name,
            users.email,
            roles.role_name,
            departments.name AS department,
            users.status,
            users.created_at

        FROM users

        LEFT JOIN roles
        ON users.role_id = roles.id

        LEFT JOIN departments
        ON users.department_id = departments.id

        WHERE users.name LIKE ?
        OR users.email LIKE ?

        ORDER BY users.created_at DESC
        ";


        $stmt = $this->db->prepare($query);


        $search = "%" . $keyword . "%";


        $stmt->execute([
            $search,
            $search
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Get users by role
    public function getUsersByRole($role_id)
    {
        $query = "
        SELECT
            users.*,
            roles.role_name

        FROM users

        INNER JOIN roles
        ON users.role_id = roles.id

        WHERE users.role_id = ?

        ORDER BY users.created_at DESC
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $role_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Count total users
    public function countUsers()
    {
        $query = "
        SELECT COUNT(*) AS total
        FROM users
        ";


        $stmt = $this->db->prepare($query);

        $stmt->execute();


        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }




    // Count users by role
    public function countUsersByRole($role_id)
    {
        $query = "
        SELECT COUNT(*) AS total
        FROM users
        WHERE role_id = ?
        ";


        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $role_id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }




    // Update user status
    public function updateUserStatus($user_id, $status)
    {
        $query = "
        UPDATE users
        SET status = ?
        WHERE id = ?
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $status,
            $user_id
        ]);
    }




    // Delete user
    public function deleteUser($user_id)
    {
        $query = "
        DELETE FROM users
        WHERE id = ?
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $user_id
        ]);
    }




    // Get single user details
    public function getUserById($user_id)
    {
        $query = "
        SELECT
            users.id,
            users.name,
            users.email,
            users.role_id,
            users.department_id,
            users.status,
            users.created_at,
            roles.role_name,
            departments.name AS department

        FROM users

        LEFT JOIN roles
        ON users.role_id = roles.id

        LEFT JOIN departments
        ON users.department_id = departments.id

        WHERE users.id = ?
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([
            $user_id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    // Update user information
    public function updateUser(
        $id,
        $name,
        $email,
        $role_id,
        $department_id,
        $status
    )
    {
        $query = "
        UPDATE users

        SET
            name = ?,
            email = ?,
            role_id = ?,
            department_id = ?,
            status = ?

        WHERE id = ?
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $name,
            $email,
            $role_id,
            $department_id,
            $status,
            $id
        ]);
    }

    // Get all departments
    public function getDepartments()
    {
        $query = "
        SELECT
            id,
            name
        FROM departments
        ORDER BY name ASC
        ";


        $stmt = $this->db->prepare($query);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} 

?>