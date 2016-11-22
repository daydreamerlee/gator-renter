<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public function getAllApartments()
    {
        $sql = "SELECT * FROM apartments";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a user information from database by user email address
     */
    public function getUserInfo($user_email)
    {
        $sql = "SELECT * FROM users WHERE email = :user_email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_email' => $user_email);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    public function getApartment($apartment_id)
    {
        $sql = "SELECT * FROM apartments WHERE id = :apartment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':apartment_id' => $apartment_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/songs.php for more)
     */
    public function getAmountOfApartments()
    {
        $sql = "SELECT COUNT(id) AS amount_of_apartments FROM apartments";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_apartments;
    }

    /**
     * Get a user information from database by user email address
     */
    public function getUserInfoById($userId)
    {
        if($userId == null)
        {
            $sql = "CALL getUserDetail(null);";
        }
        else
        {
            $sql = "CALL getUserDetail(" + $userId +");";
        }
        $query = $this->db->prepare($sql);
        $parameters = array(':uid' => $userId);

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetchall();
    }

    // saving new user in the database
    public function saveNewUser($data) {

        $sql = "INSERT INTO users (first_name, last_name, email, password, address, city, created, user_roles_id, is_active) " .
            " VALUES (:first_name, :last_name, :email, :password, :address, :city, :creationDate, :userRoleId, :isActive)";
        $query = $this->db->prepare($sql);
        $parameters = array(':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':address' => $data['address'],
            ':city' => $data['city'],
            ':creationDate' => Helper::getCurrentMySQLFormatTime(),
            ':userRoleId' => $data['role_type_id'],
            ':isActive' => 1 );

        $status = $query->execute($parameters);
        return $status;

    }
    
    // update user in the database
    public function updateUser($data) {

        $sql = "CALL updateUserDetail(" + $data['email'] + "," + $data['first_name'] + "," + $data['last_name'] + "," + $data['address'] 
                + "," + $data['city'] +")";
        $query = $this->db->prepare($sql);

        $status = $query->execute($sql);
        return $status;

    }

    //DELETE a user, it's a soft delete
    public function deleteUser($userId) {

        $sql = "UPDATE `users` SET `is_active`='0' WHERE `uid`= :userId ";
        $query = $this->db->prepare($sql);
        $parameters = array(':userId' => $userId);

        return $query->execute($parameters);

    }
}
