<?php

require_once 'app/database.php';

class Students
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insertStudent($name, $surname, $email, $login, $password)
    {
        $this->db->query('INSERT INTO users VALUES(NULL,:name,:surname,:email,:login,:password,0,NOW())');
        $this->db->bind(':name', $name);
        $this->db->bind(':surname', $surname);
        $this->db->bind(':email', $email);
        $this->db->bind(':login', $login);
        $this->db->bind(':password', $password);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function checkUserEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE usersEmail = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

