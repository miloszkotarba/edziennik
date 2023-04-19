<?php

require_once 'models/ogloszenia.php';
require_once 'alerts.php';

class Ogloszenia extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Ogloszenie();
    }

    public function index()
    {
        $this->is_logged();

        //teacher
        if ($_SESSION['usersRole'] == 1) {
            header('Location: /ogloszenia/nauczyciel');
        } else {
            header('Location: /ogloszenia/lista');
        }
    }

    public function nauczyciel()
    {
        $this->is_teacher();
        require 'views/ogloszenia/teacher.view.php';
    }

    public function lista()
    {
        $this->is_logged();
        $result = $this->Model->showAllAnnouncements();

        if ($_SESSION['usersRole'] == 1) $teacher = true;
        else $teacher = false;

        require 'views/ogloszenia/announcement.list.php';
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /home');
            exit();
        }
    }

    public function is_teacher()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 1) {
            header('Location: /ogloszenia');
            exit();
        }
    }
}

?>