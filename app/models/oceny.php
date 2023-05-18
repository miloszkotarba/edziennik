<?php

require_once 'app/database.php';

class Ocena
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function showStudentsFromLesson($zajeciaId)
    {
        $this->db->query('SELECT u.usersId, u.usersName, u.usersSurname
FROM Zajecia z JOIN Oddzialy o ON o.oddzialId = z.oddzialId JOIN users u ON u.klasaId = o.klasaId WHERE z.zajeciaId = :zajeciaId
ORDER BY u.usersSurname, u.usersName;');

        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getStudentbyId($usersId)
    {
        $this->db->query('SELECT usersName, usersSurname FROM users WHERE usersId = :usersId;');

        $this->db->bind(':usersId', $usersId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getSubjectbyZajeciaId($zajeciaId)
    {
        $this->db->query('SELECT s.subjectName FROM Zajecia z JOIN subjects s ON s.subjectId=z.subjectId WHERE z.zajeciaId = 57;');

        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showCategoriesbyZajeciaId($zajeciaId)
    {
        $this->db->query('SELECT categoryId, name FROM `categories` WHERE teacherId=(SELECT teacherId FROM Zajecia WHERE zajeciaId=:zajeciaId);');

        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function insertGrade($zajeciaId, $studentId, $categoryId, $value, $comment, $date)
    {
        $this->db->query('INSERT INTO `Oceny` VALUES (NULL, :zajeciaId, :studentId, :categoryId, :value, :date, :comment)');

        $this->db->bind(':zajeciaId', $zajeciaId);
        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':categoryId', $categoryId);
        $this->db->bind(':value', $value);
        $this->db->bind(':comment', $comment);
        $this->db->bind(':date', $date);

        $result = $this->db->execute();

        if($result) return true;
        else return false;
    }
}
