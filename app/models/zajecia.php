<?php

require_once 'app/database.php';

class Zajecie
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function checkIfClassExist($klasaId)
    {
        $this->db->query('SELECT * FROM klasa WHERE klasaId = :klasaId');
        $this->db->bind(':klasaId', $klasaId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function CurrentOddzial($klasaId)
    {
        $this->db->query('SELECT o.oddzialId FROM Oddzialy o WHERE o.klasaId = :klasaId ORDER BY SchoolYearId DESC LIMIT 1;');
        $this->db->bind(':klasaId', $klasaId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function showAllLessons($oddzialId)
    {
        $this->db->query('SELECT z.zajeciaId, z.oddzialId, z.teacherId, u.usersName, u.usersSurname, z.subjectId, s.subjectName FROM Zajecia Z JOIN subjects s ON s.subjectId = z.subjectId JOIN users u ON u.usersId = z.teacherId WHERE z.oddzialId = :oddzialId ORDER BY s.subjectName ASC;');

        $this->db->bind(':oddzialId', $oddzialId);

        $result = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showAllTeachers()
    {
        $this->db->query('SELECT usersId, usersName, usersSurname FROM nauczyciele ORDER BY usersSurname, usersName');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function showSubjectsToAssignLesson($oddzialId)
    {
        $this->db->query('SELECT subjectName, subjectId FROM subjects WHERE subjectId NOT IN(SELECT subjectId FROM Zajecia WHERE OddzialId = :oddzialId) ORDER BY subjectName;');

        $this->db->bind(':oddzialId', $oddzialId);
        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function insertLesson($oddzialId, $teacherId, $subjectId)
    {
        $this->db->query('INSERT INTO `Zajecia` (`zajeciaId`, `oddzialId`, `teacherId`, `subjectId`) VALUES (NULL, :oddzialId, :teacherId, :subjectId);');

        $this->db->bind(':oddzialId', $oddzialId);
        $this->db->bind(':teacherId', $teacherId);
        $this->db->bind(':subjectId', $subjectId);

        $result = $this->db->execute();
        if ($result) return true;
        else return false;
    }

    public function removeLesson($zajeciaId)
    {
        $this->db->query('DELETE FROM Zajecia WHERE zajeciaId = :zajeciaId');

        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->execute();
        if ($result) return true;
        else return false;
    }

    public function checkIfZajeciaExists($zajeciaId) {
        $this->db->query('SELECT * FROM Zajecia WHERE zajeciaId = :zajeciaId');
        $this->db->bind(':zajeciaId', $zajeciaId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getOddzialId($zajeciaId) {
        $this->db->query('SELECT * FROM Zajecia WHERE zajeciaId = :zajeciaId');
        $this->db->bind(':zajeciaId', $zajeciaId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
}