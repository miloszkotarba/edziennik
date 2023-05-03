<?php

require_once 'app/database.php';

class Oddzialy
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function showNotWychowawcy()
    {
        $this->db->query('SELECT u . usersId, u . usersName, u . usersSurname FROM users u LEFT JOIN klasa k ON u . usersId = k . tutorId WHERE usersRole = 1 and k . tutorId IS NULL ORDER BY u.usersSurname, u.usersName');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function checkIfNotWychowawca($usersId)
    {
        $this->db->query('SELECT u . usersId, u . usersName, u . usersSurname FROM users u LEFT JOIN klasa k ON u . usersId = k . tutorId WHERE usersRole = 1 and k . tutorId IS NULL AND u.usersId = :usersId ORDER BY u.usersSurname, u.usersName;');
        $this->db->bind(':usersId', $usersId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertOddzial($klasaName, $tutorId)
    {
        $this->db->query('INSERT INTO klasa VALUES(NULL,:klasaName,:tutorId)');
        $this->db->bind(':klasaName', $klasaName);
        $this->db->bind(':tutorId', $tutorId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function checkOddzialUnique($klasaName)
    {
        $this->db->query('SELECT * FROM klasa WHERE klasaName = :klasaName');
        $this->db->bind(':klasaName', $klasaName);

        $final = $this->db->execute();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function showAllOddzial()
    {
        $this->db->query('SELECT k.klasaId, k.klasaName, u.usersName, u.usersSurname FROM users u RIGHT JOIN klasa k ON u . usersId = k . tutorId WHERE u.usersRole=1
ORDER BY k.klasaName;');

        $final = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $final;
        } else {
            return false;
        }
    }


}