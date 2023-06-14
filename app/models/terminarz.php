<?php

require_once 'app/database.php';

class Zdarzenie
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllClasses()
    {
        $this->db->query('SELECT o.oddzialId, (SELECT klasaName FROM klasa WHERE klasaId = o.klasaId) klasaName, (SELECT usersName FROM users WHERE usersId = (SELECT tutorId FROM klasa WHERE klasaid = o.klasaId)) usersName, (SELECT usersSurname FROM users WHERE usersId = (SELECT tutorId FROM klasa WHERE klasaid = o.klasaId)) usersSurname FROM Oddzialy o WHERE SchoolYearId = (SELECT YearId FROM SchoolYear ORDER BY semestr2do DESC LIMIT 1) ORDER BY klasaName;');

        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) return $row;
        else return false;
    }
}