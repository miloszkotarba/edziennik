<?php

require_once 'app/database.php';

class Ogloszenie
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function is_teacher()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 1) {
            header('Location: /oceny');
            exit();
        }
    }

    public function showAllAnnouncements()
    {
        $this->db->query('SELECT a.title, u.usersName, u.usersSurname, DATE_FORMAT(a.date, "%d-%m-%Y %H:%i") date, a.content
FROM announcements a JOIN users u ON u.usersId = a.teacherId
ORDER BY a.date DESC;');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
}