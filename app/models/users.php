<?php

require_once 'app/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //Find user by username
    public function findUserByLogin($login)
    {
        $this->db->query('SELECT * FROM users WHERE usersLogin = :login');
        $this->db->bind(':login', $login);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    //Login - check password
    public function login($login, $password)
    {
        $row = $this->findUserByLogin($login);
        if ($row == false) return false;

        $hashedPassword = $row->usersPassword;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }
}