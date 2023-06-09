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

    public function dodaj()
    {
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

        $final = $this->Model->insertOddzial($data['name'], $data['wychowawcaId']);
        $SchoolYearId = $this->Model->checkSchoolYearId();
        $SchoolYearId = $SchoolYearId[0]->YearId;
        $klasaId = $this->Model->checkKlasaId($data['name']);
        $klasaId = $klasaId[0]->klasaId;
        $this->Model->createOddzial($klasaId, $SchoolYearId);
        if (!$final) {
            alerts::SetError("Błąd: Nie dodano klasy.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Dodano klasę.");
            header('Location: /oddzial/list');
        }
    }

    public function list()
    {
        $this->is_admin();
        $result = $this->Model->showAllOddzial();
        require 'views/admin/klasa/klasa.list.php';
    }

    public function delete($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) {
            redirect('/oddzial/list');
        }

        $result = $this->Model->deleteOddzial($link);

        if (!$result) {
            alerts::SetError("Błąd. Nie można usunąć klasy.");
            redirect('/oddzial/list');
        }

        $final = $this->Model->deleteKlasa($link);

        if ($final) {
            alerts::SetSuccess("Usunięto klasę.");
            redirect('/oddzial/list');
        } else {
            alerts::SetError("Błąd. Nie można usunąc klasy");
            redirect('/oddzial/list');
        }
    }

    public function edit($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) {
            redirect('/oddzial/list');
        }

        $result = $this->Model->showNotWychowawcy2($link);
        $klasaName = $this->Model->checkOddzialUniqueId($link);
        $klasaName = $klasaName[0]->klasaName;
        require 'views/admin/klasa/klasa.edit.php';
    }

    public function edytuj()
    {
        $this->is_admin();
        //Init data
        $data = [
            'name' => trim($_POST['name']),
            'wychowawcaId' => trim($_POST['wychowawcaId']),
            'klasaId' => trim($_POST['klasaId'])
        ];

        $link = '/oddzial/edit/'.$data['klasaId'];

        //Validate inputs
        if (empty($data['name']) || empty($data['wychowawcaId'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect($link);
        }

        if (strlen($data['name']) > 10) {
            alerts::SetError("Nazwa nie może być dłuższa niż 10 znaków.", 0);
            redirect($link);
        }

        if (strlen($data['name']) < 1) {
            alerts::SetError("Nazwa nie może być krótsza niż 1 znaki.", 0);
            redirect($link);
        }

        $data['name'] = htmlspecialchars($data['name']);
        $data['wychowawcaId'] = htmlspecialchars($data['wychowawcaId']);

        $nazwa = $this->Model->checkOddzialUnique2($data['name'],$data['klasaId']);
        if ($nazwa == true) {
            alerts::SetError("Klasa o takiej nazwie już istnieje.", 0);
            redirect($link);
        }

        $final = $this->Model->updateKlasa($data['klasaId'],$data['name'],$data['wychowawcaId']);
        if (!$final) {
            alerts::SetError("Błąd: Nie zmodyfikowano klasy.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Zmodyfikowano klasę.");
            header('Location: /oddzial/list');
        }
    }
}