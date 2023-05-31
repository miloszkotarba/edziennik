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

    public function showUserId($email)
    {
        $this->db->query('SELECT usersId FROM users WHERE usersEmail = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function deleteTeacher($usersId)
    {
        try {
            $this->db->query('DELETE FROM users WHERE usersId = :usersId');
            $this->db->bind(':usersId', $usersId);

            $row = $this->db->execute();

            if ($row) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkIfTeacherCanBeDeleted($teacherId)
    {
        $this->db->query('SELECT zajeciaId FROM Zajecia WHERE teacherId = :teacherId LIMIT 1');
        $this->db->bind(':teacherId', $teacherId);

        $row = $this->db->single();
        $row = $this->db->rowCount();

        if ($this->db->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getTeacherById($teacherId)
    {
        $this->db->query('SELECT * FROM users WHERE usersId = :usersId AND usersRole = 1');
        $this->db->bind(':usersId', $teacherId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function modifyTeacher($teacherId, $usersName, $usersSurname, $usersEmail, $usersLogin, $usersPassword)
    {
        $this->db->query('UPDATE users SET usersName = :usersName, usersSurname = :usersSurname, usersEmail = :usersEmail, usersLogin = :usersLogin, usersPassword = :usersPassword WHERE usersId = :usersId');
        $this->db->bind(':usersId', $teacherId);
        $this->db->bind(':usersName', $usersName);
        $this->db->bind(':usersSurname', $usersSurname);
        $this->db->bind(':usersEmail', $usersEmail);
        $this->db->bind(':usersLogin', $usersLogin);
        $this->db->bind(':usersPassword', $usersPassword);

        $result = $this->db->execute();

        if ($result) return true;
        else return false;
    }
}

