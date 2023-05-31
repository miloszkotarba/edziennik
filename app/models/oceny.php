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
        $this->db->query('SELECT s.subjectName FROM Zajecia z JOIN subjects s ON s.subjectId=z.subjectId WHERE z.zajeciaId = :zajeciaId;');

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
        $this->db->query('SELECT categoryId, name FROM `categories` WHERE teacherId=(SELECT teacherId FROM Zajecia WHERE zajeciaId=:zajeciaId) AND name != "przewidywana śródroczna" AND name != "przewidywana roczna" AND name != "śródroczna" AND name != "roczna" ORDER BY name ASC;');

        $this->db->bind(':zajeciaId', $zajeciaId);

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function showSystemCategories($zajeciaId)
    {
        $this->db->query('SELECT categoryId, name FROM `categories` WHERE teacherId=(SELECT teacherId FROM Zajecia WHERE zajeciaId=:zajeciaId) AND name IN("przewidywana śródroczna","przewidywana roczna", "roczna", "śródroczna") ORDER BY name ASC;');

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

        if ($result) return true;
        else return false;
    }

    public function showLessonsforStudent($studentId)
    {
        $this->db->query('SELECT z.zajeciaId, s.subjectName FROM Zajecia z JOIN subjects s ON s.subjectId = z.subjectId WHERE z.oddzialId = (SELECT oddzialId FROM Oddzialy WHERE klasaId = (SElECT klasaId FROM users WHERE usersId = :studentId)) ORDER BY s.subjectName;');

        $this->db->bind(':studentId', $studentId);

        $result = $this->db->resultSet();
        if ($result) return $result;
        else return false;
    }


    public function getSubjectbyGradeId($ocenaId)
    {
        $this->db->query('SELECT s.subjectName
FROM Oceny o JOIN Zajecia z ON o.zajeciaId = z.zajeciaId JOIN subjects s ON s.subjectId = z.subjectId
WHERE o.ocenaId = :ocenaId;');

        $this->db->bind(':ocenaId', $ocenaId);

        $result = $this->db->single();
        if ($result) return $result;
        else return false;
    }

    public function getZajeciabyGradeId($ocenaId)
    {
        $this->db->query('SELECT zajeciaId from Oceny
WHERE ocenaId = :ocenaId;');

        $this->db->bind(':ocenaId', $ocenaId);

        $result = $this->db->single();
        if ($result) return $result;
        else return false;
    }

    public function deleteGrade($ocenaId)
    {
        $this->db->query('DELETE FROM Oceny WHERE ocenaId = :ocenaId');
        $this->db->bind(':ocenaId', $ocenaId);

        $result = $this->db->execute();
        if ($result) return true;
        else return false;
    }

    public function showNamebyCategoryId($categoryId)
    {
        $this->db->query('SELECT name FROM categories WHERE categoryId = :categoryId');
        $this->db->bind(':categoryId', $categoryId);

        $result = $this->db->single();
        if ($result) return $result;
        else return false;
    }

    public function checkSystemGrade($categoryId, $zajeciaId, $studentId)
    {
        $this->db->query('SELECT ocenaId FROM Oceny WHERE categoryId = :categoryId AND zajeciaId = :zajeciaId AND studentId = :studentId');

        $this->db->bind(':categoryId', $categoryId);
        $this->db->bind(':zajeciaId', $zajeciaId);
        $this->db->bind(':studentId', $studentId);

        $result = $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getGradeValueCommentCategory($ocenaId)
    {
        $this->db->query('SELECT o.value, o.date,(SELECT name FROM categories WHERE categoryId = o.categoryId) categoryName, o.comment FROM Oceny o WHERE o.ocenaId = :ocenaId;');

        $this->db->bind(':ocenaId', $ocenaId);

        $result = $this->db->single();
        if ($this->db->rowCount() > 0) return $result;
        else return false;
    }

    public function updateGrade($ocenaId, $value, $date, $comment, $categoryId)
    {
        $this->db->query('UPDATE Oceny SET value = :value, date = :date, comment = :comment, categoryId = :categoryId WHERE ocenaId = :ocenaId');

        $this->db->bind(':ocenaId', $ocenaId);
        $this->db->bind(':value', $value);
        $this->db->bind(':date', $date);
        $this->db->bind(':comment', $comment);
        $this->db->bind(':categoryId', $categoryId);

        $result = $this->db->execute();
        if ($result) return true;
        else return false;
    }
}
