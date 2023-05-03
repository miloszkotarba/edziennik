<?php

require_once 'models/oddzial.php';
require_once 'alerts.php';

class Oddzial extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Oddzialy();
    }

    public function index()
    {
        $this->is_admin();
        $result = $this->Model->showNotWychowawcy();
        require 'views/admin/klasa/klasa.add.php';
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

    public function dodaj() {
        $this->is_admin();
        //Init data
        $data = [
            'name' => trim($_POST['name']),
            'wychowawcaId' => trim($_POST['wychowawcaId'])
        ];

        //Validate inputs
        if (empty($data['name']) || empty($data['wychowawcaId'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/oddzial');
        }

        if (strlen($data['name']) > 10) {
            alerts::SetError("Nazwa nie może być dłuższa niż 10 znaków.", 0);
            redirect('/oddzial');
        }

        if (strlen($data['name']) < 1) {
            alerts::SetError("Nazwa nie może być krótsza niż 1 znaki.", 0);
            redirect('/oddzial');
        }

        $data['name'] = htmlspecialchars($data['name']);
        $data['wychowawcaId'] = htmlspecialchars($data['wychowawcaId']);

        $wychowawca = $this->Model->checkIfNotWychowawca($data['wychowawcaId']);
        if ($wychowawca == false) {
            alerts::SetError("Błąd: Nie dodano klasy.", 0);
            redirect('/oddzial');
        }

        $nazwa = $this->Model->checkOddzialUnique($data['name']);
        if ($nazwa == true) {
            alerts::SetError("Klasa o takiej nazwie już istnieje.", 0);
            redirect('/oddzial');
        }

        $final = $this->Model->insertOddzial($data['name'],$data['wychowawcaId']);
        if (!$final) {
            alerts::SetError("Błąd: Nie dodano klasy.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Dodano klasę.");
            header('Location: /oddzial/list');
        }
    }

    public function list() {
        $result = $this->Model->showAllOddzial();
        require 'views/admin/klasa/klasa.list.php';
    }
}