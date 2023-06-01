<?php

require_once 'app/database.php';

class Grade
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function showGradesForEachStudent($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.zajeciaId, o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr1do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) ORDER BY o.date;');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showGradesForEachSubject($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.zajeciaId, o.ocenaId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr1do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) ORDER BY o.date;');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showGradesForEachSubjectSem2($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.zajeciaId, o.ocenaId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr2od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) ORDER BY o.date;');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showGradesForEachStudentSem2($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr2od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) ORDER BY o.date;');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showPrzewidywanaSrodroczna($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name = "przewidywana śródroczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1));');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showSrodroczna($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name = "śródroczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1));');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showPrzewidywanaRoczna($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name = "przewidywana roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1));');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showRoczna($studentId, $zajeciaId)
    {
        $this->db->query('SELECT o.ocenaId, o.studentId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name = "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1));');

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function SredniaSem1($zajeciaId, $studentId)
    {
        $this->db->query('WITH widok AS(SELECT o.zajeciaId, o.ocenaId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr1od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr1do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) AND o.value NOT IN("np","bz","+","-") ORDER BY o.date)
SELECT ROUND((SUM(value*weight)/SUM(weight)),2) srednia FROM widok;');
        $this->db->bind(':zajeciaId', $zajeciaId);
        $this->db->bind(":studentId", $studentId);

        $result = $this->db->single();

        return $result;
    }

    public function SredniaSem2($zajeciaId, $studentId)
    {
        $this->db->query('WITH widok AS(SELECT o.zajeciaId, o.ocenaId, o.value, CONCAT("#",c.color) color, c.weight, c.averageCount, c.name, o.comment, DATE_FORMAT(o.date, "%d-%m-%Y") date, u.usersName, u.usersSurname FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name != "przewidywana śródroczna" AND c.name != "śródroczna" AND c.name != "przewidywana roczna" AND c.name != "roczna" AND o.zajeciaId = :zajeciaId AND ( o.date>=(SELECT semestr2od FROM SchoolYear ORDER BY YearId DESC LIMIT 1)  AND o.date<=(SELECT semestr2do FROM SchoolYear ORDER BY YearId DESC LIMIT 1)) AND o.value NOT IN("np","bz","+","-") ORDER BY o.date)
SELECT ROUND((SUM(value*weight)/SUM(weight)),2) srednia FROM widok;');
        $this->db->bind(':zajeciaId', $zajeciaId);
        $this->db->bind(":studentId", $studentId);

        $result = $this->db->single();

        return $result;
    }

    public function getSystemGradesByStudent($studentId, $zajeciaId)
    {
        $this->db->query("SELECT o.ocenaId, o.studentId, o.value, c.name FROM Oceny o JOIN categories c ON c.categoryId = o.categoryId JOIN Zajecia z ON z.zajeciaId = o.zajeciaId JOIN users u ON u.usersId = z.teacherId WHERE o.studentId = :studentId AND c.name IN ('przewidywana śródroczna','śródroczna', 'przewidywana roczna','roczna') AND o.zajeciaId = :zajeciaId ORDER BY c.name;");

        $this->db->bind(':studentId', $studentId);
        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) return $result;
        else return false;
    }
}