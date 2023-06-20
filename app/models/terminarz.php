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

    public function getEventsforClass($oddzialId)
    {
        $this->db->query('SELECT (SELECT usersName FROM users WHERE usersId = t.usersId) imie,  (SELECT usersSurname FROM users WHERE usersId = t.usersId) nazwisko, t.zdarzenieId, t.opis, (SELECT nazwa FROM terminarz_kategorie WHERE categoryId = t.id_kategorii) kategoria, CONCAT("#",tk.color) color, DATE_FORMAT(t.data, "%d-%m-%Y") data, DATE_FORMAT(t.czasOd, "%H:%i") czasOd, DATE_FORMAT(t.czasDo, "%H:%i") czasDo, (SELECT subjectName FROM subjects WHERE subjectId = (SELECT subjectId FROM Zajecia WHERE zajeciaId = t.zajeciaId)) zajecia, (SELECT klasaName FROM klasa WHERE klasaId = (SELECT klasaId FROM Oddzialy WHERE oddzialId = t.oddzialId)) klasa, t.data_dodania FROM terminarz t  JOIN terminarz_kategorie tk ON tk.categoryId = t.id_kategorii WHERE oddzialId = :oddzialId ORDER BY data, czasOd, data_dodania');
        $this->db->bind(':oddzialId', $oddzialId);
        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else
            return false;
    }
}