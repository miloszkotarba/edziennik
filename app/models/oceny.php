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
}
