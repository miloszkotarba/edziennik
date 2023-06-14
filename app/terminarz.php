<?php
require_once 'alerts.php';
require_once 'models/terminarz.php';

class Terminarz extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Zdarzenie();
    }

    public function index()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] == 1 || $_SESSION['usersRole'] == 2) {
            header('Location: /terminarz/oddzialy');
        } else {
            require 'views/terminarz/student.view.php';
        }
    }

    public function oddzialy()
    {
        $this->is_teacher();
        $result = $this->Model->getAllClasses();
        require 'views/terminarz/teacher.view.php';
    }

    public function szczegoly($oddzialId = NULL) {
        if($oddzialId == NULL) redirect('/terminarz');
        require 'views/terminarz/oddzial.show.php';
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
        if ($_SESSION['usersRole'] != 1 && $_SESSION['usersRole'] != 2) {
            header('Location: /terminarz');
            exit();
        }
    }
}