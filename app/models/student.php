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
        $this->db->query('INSERT INTO users VALUES(NULL,:name,:surname,:email,:login,:password,0,NOW(),NULL)');
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

    public function checkIfStudentHaveGrades($studentId)
    {
        $this->db->query('SELECT studentId FROM Oceny WHERE studentId = :studentId LIMIT 1;');
        $this->db->bind(':studentId', $studentId);

        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIfStudentHaveClass($studentId)
    {
        $this->db->query('SELECT studentId FROM Oceny WHERE studentId = :studentId LIMIT 1;');
        $this->db->bind(':studentId', $studentId);

        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteStudentFromClass($usersId)
    {
        $this->db->query('UPDATE `users` SET `klasaId` = NULL WHERE `users`.`usersId` = :usersId;');
        $this->db->bind(':usersId', $usersId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function getUserInfo($usersId)
    {
        $this->db->query('SELECT usersRole, klasaId FROM users WHERE usersId = :usersId;');
        $this->db->bind(':usersId', $usersId);

        $final = $this->db->resultSet();
        if ($final) return $final;
        else return false;
    }

    public function updateStudentClass($usersId,$klasaId)
    {
        $this->db->query('UPDATE `users` SET `klasaId` = :klasaId WHERE `users`.`usersId` = :usersId;');
        $this->db->bind(':usersId', $usersId);
        $this->db->bind(':klasaId', $klasaId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }
}

