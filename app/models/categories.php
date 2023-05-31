<?php

require_once 'app/database.php';

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //Find Category by Name and UserId
    public function findCategoryByName($teacherId, $name)
    {
        $this->db->query('SELECT * FROM categories WHERE teacherId = :teacherId AND name = :name');
        $this->db->bind(':teacherId', $teacherId);
        $this->db->bind(':name', $name);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertCategory($name, $weight, $color, $averageCount, $teacherId)
    {
        $this->db->query('INSERT INTO categories VALUES(NULL,:name,:weight,:color,:averageCount,:teacherId)');
        $this->db->bind(':name', $name);
        $this->db->bind(':weight', $weight);
        $this->db->bind(':color', $color);
        $this->db->bind(':averageCount', $averageCount);
        $this->db->bind(':teacherId', $teacherId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function modifyCategory($name, $weight, $color, $averageCount, $categoryId)
    {
        $this->db->query('UPDATE categories SET name = :name, weight = :weight, color = :color, averageCount = :averageCount WHERE categoryId = :categoryId');
        $this->db->bind(':name', $name);
        $this->db->bind(':weight', $weight);
        $this->db->bind(':color', $color);
        $this->db->bind(':averageCount', $averageCount);
        $this->db->bind(':categoryId', $categoryId);

        $final = $this->db->execute();
        if ($final) return true;
        else return false;
    }

    public function showAllCategories($teacherId)
    {
        $this->db->query('SELECT categoryId, name, CONCAT("#",color) color FROM categories WHERE teacherId = :teacherId ORDER BY name;');
        $this->db->bind(':teacherId', $teacherId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function showCategoriesWithoutBasic($teacherId)
    {
        $this->db->query('SELECT categoryId, name, CONCAT("#",color) color FROM categories WHERE teacherId = :teacherId AND name != "przewidywana śródroczna" AND name != "śródroczna" AND name != "przewidywana roczna" AND name != "roczna" ORDER BY name;');
        $this->db->bind(':teacherId', $teacherId);

        $row = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function showCategory($categoryId)
    {
        $this->db->query('SELECT * FROM categories WHERE categoryId = :categoryId;');
        $this->db->bind(':categoryId', $categoryId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function checkCategoryOwner($teacherId, $categoryId)
    {
        $this->db->query('SELECT * FROM categories WHERE teacherId = :teacherId AND categoryId = :categoryId');
        $this->db->bind(':teacherId', $teacherId);
        $this->db->bind(':categoryId', $categoryId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCategory($categoryId)
    {
        try {
            $this->db->query('DELETE FROM categories WHERE categoryId = :categoryId');
            $this->db->bind(':categoryId', $categoryId);

            $final = $this->db->execute();
            if ($final) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteAllCategories($teacherId) {
        try {
            $this->db->query('DELETE FROM categories WHERE teacherId = :teacherId');
            $this->db->bind(':teacherId', $teacherId);

            $final = $this->db->execute();
            if ($final) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }
}