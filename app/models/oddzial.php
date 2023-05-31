<?php

require_once 'app/database.php';

class Oddzialy
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function showNotWychowawcy()
    {
        $this->db->query('SELECT u . usersId, u . usersName, u . usersSurname FROM users u LEFT JOIN klasa k ON u . usersId = k . tutorId WHERE usersRole = 1 and k . tutorId IS NULL ORDER BY u.usersSurname, u.usersName');

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function showNotWychowawcy2($klasaId)
    {
        $this->db->query('SELECT u . usersId, u . usersName, u . usersSurname FROM users u LEFT JOIN klasa k ON u . usersId = k . tutorId WHERE usersRole = 1 and k . tutorId IS NULL                                                                                                           UNION ALL
SELECT (SELECT usersId FROM users WHERE usersId = k.tutorId), (SELECT usersName FROM users WHERE usersId = k.tutorId), (SELECT usersSurname FROM users WHERE usersId = k.tutorId)
FROM klasa k
WHERE k.klasaId = :klasaId
ORDER BY 3,2;');

        $this->db->bind(':klasaId', $klasaId);
        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function checkIfNotWychowawca($usersId)
    {
        $this->db->query('SELECT u . usersId, u . usersName, u . usersSurname FROM users u LEFT JOIN klasa k ON u . usersId = k . tutorId WHERE usersRole = 1 and k . tutorId IS NULL AND u.usersId = :usersId ORDER BY u.usersSurname, u.usersName;');
        $this->db->bind(':usersId', $usersId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertOddzial($klasaName, $tutorId)
    {
        $this->db->query('INSERT INTO klasa VALUES(NULL,:klasaName,:tutorId)');
        $this->db->bind(':klasaName', $klasaName);
        $this->db->bind(':tutorId', $tutorId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function checkOddzialUnique($klasaName)
    {
        $this->db->query('SELECT * FROM klasa WHERE klasaName = :klasaName');
        $this->db->bind(':klasaName', $klasaName);

        $final = $this->db->execute();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkOddzialUnique2($klasaName, $klasaId)
    {
        $this->db->query('SELECT * FROM klasa WHERE klasaName = :klasaName AND klasaId != :klasaId');
        $this->db->bind(':klasaName', $klasaName);
        $this->db->bind(':klasaId', $klasaId);

        $final = $this->db->execute();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function checkOddzialUniqueId($klasaId)
    {
        $this->db->query('SELECT * FROM klasa WHERE klasaId = :klasaId');
        $this->db->bind(':klasaId', $klasaId);

        $final = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $final;
        } else {
            return false;
        }
    }

    public function checkOddzialExists($oddzialId)
    {
        $this->db->query('SELECT * FROM Oddzialy WHERE oddzialId = :oddzialId');
        $this->db->bind(':oddzialId', $oddzialId);

        $final = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkKlasaId($klasaName)
    {
        $this->db->query('SELECT klasaId FROM klasa WHERE klasaName = :klasaName');
        $this->db->bind(':klasaName', $klasaName);
        $final = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $final;
        } else {
            return false;
        }
    }

    public function showAllOddzial()
    {
        $this->db->query('SELECT k.klasaId, k.klasaName, u.usersName, u.usersSurname FROM users u RIGHT JOIN klasa k ON u . usersId = k . tutorId WHERE u.usersRole=1
ORDER BY k.klasaName;');

        $final = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $final;
        } else {
            return false;
        }
    }

    public function checkSchoolYearId()
    {
        $this->db->query('SELECT YearId FROM SchoolYear ORDER BY semestr2do DESC LIMIT 1');
        $row = $this->db->resultSet();
        if ($row) return $row;
        else return false;
    }

    public function createOddzial($klasaId, $SchoolYearId)
    {
        $this->db->query('INSERT INTO `Oddzialy` (`oddzialId`, `klasaId`, `SchoolYearId`) VALUES (NULL, :klasaId, :SchoolYearId);');
        $this->db->bind(':klasaId', $klasaId);
        $this->db->bind(':SchoolYearId', $SchoolYearId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function showOddzialName($klasaId)
    {
        $this->db->query('SELECT klasaName FROM klasa WHERE klasaId = :klasaId');
        $this->db->bind(':klasaId', $klasaId);
        $row = $this->db->resultSet();
        if ($row) return $row;
        else return false;
    }

    public function showAllStudents()
    {
        $this->db->query('SELECT u.usersId, u.usersName, u.usersSurname, u.usersEmail, DATE_FORMAT(u.createDate, "%d-%m-%Y %H:%i") createDate, u.klasaId, k.klasaName
FROM users u LEFT JOIN klasa k ON u.klasaId = k.klasaId
WHERE usersRole = 0
ORDER BY usersSurname, usersName;');

        $result = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function deleteOddzial($klasaId)
    {
        try {
            $this->db->query('DELETE FROM Oddzialy WHERE klasaId = :klasaId');
            $this->db->bind(':klasaId', $klasaId);

            $row = $this->db->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteKlasa($klasaId)
    {
        try {
            $this->db->query('DELETE FROM klasa WHERE klasaId = :klasaId');
            $this->db->bind(':klasaId', $klasaId);

            $row = $this->db->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateKlasa($klasaId, $klasaName, $tutorId) {
        $this->db->query('UPDATE klasa SET klasaName = :klasaName, tutorId = :tutorId WHERE klasaId = :klasaId');
        $this->db->bind(':klasaId', $klasaId);
        $this->db->bind(':klasaName', $klasaName);
        $this->db->bind(':tutorId', $tutorId);

        $row = $this->db->execute();
        if($this -> db ->rowCount() > 0) return $row;
        else return false;
    }
}