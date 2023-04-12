<?php

require_once 'app/database.php';

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //Find Category by Name and UserId
    public function findCategoryByName($teacherId,$name)
    {
        $this->db->query('SELECT * FROM categories WHERE teacherId = :teacherId AND name = :name');
        $this->db->bind(':teacherId', $teacherId);
        $this->db->bind(':name', $name);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Login - check password
    /*public function login($login, $password)
    {
        $row = $this->findUserByLogin($login);
        if ($row == false) return false;

        $hashedPassword = $row->usersPassword;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }*/
}