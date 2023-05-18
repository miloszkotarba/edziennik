<?php

require_once 'models/zajecia.php';
require_once 'models/oddzial.php';
require_once 'alerts.php';

class Zajecia extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Zajecie();
        $this->ModelOddzial = new Oddzialy();
    }

    public function index()
    {
        $this->is_admin();
        $result = $this->ModelOddzial->showAllOddzial();
        require 'views/admin/zajecia/zajecia.list.php';
    }

    public function list($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) {
            redirect('/zajecia');
        }

        $result = $this->Model->checkIfClassExist($link);
        if (!$result) {
            redirect('/zajecia');
        }

        $currentOddzial = $this->Model->CurrentOddzial($link);
        $currentOddzial = $currentOddzial[0]->oddzialId;
        $className = $this->ModelOddzial->showOddzialName($link);
        $className = $className[0]->klasaName;
        $result = $this->Model->showAllLessons($currentOddzial);

        require 'views/admin/zajecia/zajecia.add.php';
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /dashboard');
            exit();
        }
    }

    public function is_admin()
    {
        $this->is_logged();
        if ($_SESSION['usersRole'] != 2) {
            header('Location: /dashboard');
            exit();
        }
    }

    public function add($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) {
            redirect('/zajecia');
        }

        $result = $this->ModelOddzial->checkOddzialExists($link);
        if (!$result) {
            redirect('/zajecia');
        }

        $teachers = $this->Model->showAllTeachers();
        $subjects = $this->Model->showSubjectsToAssignLesson($link);

        $className = $this->ModelOddzial->showOddzialName($link);
        $className = $className[0]->klasaName;
        require 'views/admin/zajecia/zajecia.new.php';
    }

    public function new()
    {
        $this->is_admin();
        //Init data

        if (!isset($_POST['przedmiotId'])) {
            redirect('/zajecia');
        }
        $data = [
            'przedmiotId' => trim($_POST['przedmiotId']),
            'nauczycielId' => trim($_POST['nauczycielId']),
            'oddzialId' => trim($_POST['oddzialId'])
        ];


        //Validate inputs
        if (empty($data['przedmiotId']) || empty($data['nauczycielId']) || empty($data['oddzialId'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/zajecia/list');
        }

        $data['przedmiotId'] = htmlspecialchars($data['przedmiotId']);
        $data['nauczycielId'] = htmlspecialchars($data['nauczycielId']);
        $data['oddzialId'] = htmlspecialchars($data['oddzialId']);
        $url = '/zajecia/list/' . $data['oddzialId'];

        $final = $this->Model->insertLesson($data['oddzialId'], $data['nauczycielId'], $data['przedmiotId']);
        if ($final) {
            alerts::SetSuccess("Dodano przedmiot do klasy.");
            redirect($url);
        } else {
            alerts::SetError("Błąd. Nie przypisano przedmiotu do klasy.");
            redirect($url);
        }
    }

    public function remove($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) redirect('/zajecia');
        $row = $this->Model->checkIfZajeciaExists($link);
        if (!$row) {
            redirect('/zajecia');
        }
        $oddzial = $this->Model->getOddzialId($link);
        $oddzial = $oddzial[0] -> oddzialId;
        $url = '/zajecia/list/'.$oddzial;
        $final = $this->Model->removeLesson($link);
        if ($final) {
            alerts::SetSuccess("Usunięto przypisanie przedmiotu.");
            redirect($url);
        } else {
            alerts::SetError("Błąd: Nie usunięto przypisania przedmiotu.");
            redirect($url);
        }
    }
}