<?php

require_once 'app/database.php';

class Subjects
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insertSubject($name)
    {
        $this->db->query('INSERT INTO subjects VALUES(NULL,:name)');
        $this->db->bind(':name', $name);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function checkSubject($name)
    {
        $this->db->query('SELECT * FROM subjects WHERE subjectName = :name');
        $this->db->bind(':name', $name);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkSubjectId($id)
    {
        $this->db->query('SELECT * FROM subjects WHERE subjectId = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAllSubjects()
    {
        $this->db->query('SELECT * FROM subjects ORDER BY subjectName ASC');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function deleteSubject($subjectId)
    {
        try{
        $this->db->query('DELETE FROM subjects WHERE subjectId = :subjectId');
        $this->db->bind(':subjectId', $subjectId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;} catch(Exception $e) {
           return false;
        }
    }

    public function modifySubject($subjectId, $subjectName) {
        $this->db->query('UPDATE subjects SET subjectName = :subjectName WHERE subjectId = :subjectId');
        $this->db->bind(':subjectId', $subjectId);
        $this->db->bind(':subjectName', $subjectName);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }
}

