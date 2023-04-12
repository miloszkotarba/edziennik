<?php

require_once 'models/categories.php';

class Oceny extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Category();
    }

    public function index()
    {
        $this->is_logged();

        //teacher
        if ($_SESSION['usersRole'] == 1) {
            header('Location: /oceny/nauczyciel');
        } else {
            echo "UCZEN";
        }
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /home');
            exit();
        }
    }

    /* NAUCZYCIEL */

    public function nauczyciel()
    {
        $this->is_teacher();
        require 'views/oceny/teacher.view.php';
    }

    public function kategorie($link = NULL)
    {
        if ($link == NULL)
        {
            header('Location: /oceny');
            exit();
        }

        $this->is_teacher();

        switch ($link) {
            case "dodaj":
                require 'views/oceny/teacher.category.add.php';
                break;
            case "modyfikuj":
                echo "Modyfikacja";
                break;
            default:
                header('Location: /blad');
                exit();
                break;
        }
    }

    public function dodaj_kategorie() {

    }

    public function is_teacher()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 1) {
            header('Location: /oceny');
            exit();
        }
    }
}