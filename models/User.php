<?php

require_once __DIR__ . "/../config/database.php";


class User
{

    private $db;


    public function __construct()
    {

        $database = new Database();

        $this->db = $database->connect();

    }



    // Find user by email

    public function findByEmail($email)
    {

        $query = "
        SELECT *
        FROM users
        WHERE email = ?
        ";


        $stmt = $this->db->prepare($query);


        $stmt->execute([$email]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }



    // Create new user

    public function createUser(
        $name,
        $email,
        $password,
        $role_id,
        $department_id
    )
    {

        $query = "
        INSERT INTO users
        (
            name,
            email,
            password,
            role_id,
            department_id
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
        ";


        $stmt = $this->db->prepare($query);


        return $stmt->execute([
            $name,
            $email,
            $password,
            $role_id,
            $department_id
        ]);

    }



}

?>