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
        $this->db->query('SELECT a.announcementId, a.teacherId, a.title, u.usersName, u.usersSurname, DATE_FORMAT(a.date, "%d-%m-%Y %H:%i") date, a.content
FROM announcements a JOIN users u ON u.usersId = a.teacherId
ORDER BY a.date DESC;');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function insertAnnouncement($title, $content, $teacherId)
    {
        $this->db->query('INSERT INTO announcements VALUES(NULL,:title,:content,NOW(),:teacherId)');
        $this->db->bind(':title', $title);
        $this->db->bind(':content', $content);
        $this->db->bind(':teacherId', $teacherId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function checkAnnouncementOwner($teacherId, $announcementId)
    {
        $this->db->query('SELECT * FROM announcements WHERE teacherId = :teacherId AND announcementId = :announcementId');
        $this->db->bind(':teacherId', $teacherId);
        $this->db->bind(':announcementId', $announcementId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAnnouncement($announcementId)
    {
        $this->db->query('DELETE FROM announcements WHERE announcementId = :announcementId');
        $this->db->bind(':announcementId', $announcementId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }
}