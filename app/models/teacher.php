<?php

require_once 'app/database.php';

class Teachers
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function showAllTeachers()
    {
        $this->db->query('SELECT usersId, usersName, usersSurname, usersEmail, DATE_FORMAT(createDate, "%d-%m-%Y %H:%i") createDate FROM users WHERE usersRole = 1 ORDER BY usersSurname, usersName');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function insertTeacher($name, $surname, $email, $login, $password)
    {
        $this->db->query('INSERT INTO users VALUES(NULL,:name,:surname,:email,:login,:password,1,NOW(),NULL)');
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

    public function showUserId($email) {
        $this->db->query('SELECT usersId FROM users WHERE usersEmail = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
}

