<?php

require_once 'models/subject.php';
require_once 'alerts.php';

class Subject extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Subjects();
    }

    public function index()
    {
        $this->is_admin();
        require 'views/admin/subject/subject.add.php';
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
        ];

        //Validate inputs
        if (empty($data['name'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/subject');
        }

        if (strlen($data['name']) > 30) {
            alerts::SetError("Nazwa nie może być dłuższa niż 30 znaków.", 0);
            redirect('/subject');
        }

        if (strlen($data['name']) < 4) {
            alerts::SetError("Nazwa nie może być krótsza niż 4 znaki.", 0);
            redirect('/subject');
        }

        $nazwa = $this->Model->checkSubject($data['name']);
        if ($nazwa == true) {
            alerts::SetError("Nazwa przedmiotu jest zajęta.", 0);
            redirect('/subject');
        }

        $data['name'] = htmlspecialchars($data['name']);

        $final = $this->Model->insertSubject($data['name']);
        if (!$final) {
            alerts::SetError("Błąd: Nie dodano przedmiotu.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Dodano przedmiot.");
            header('Location: /subject/list');
        }
    }

    public function list()
    {
        $this->is_admin();
        $result = $this->Model->getAllSubjects();
        require 'views/admin/subject/subject.list.php';
    }

    public function delete($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) redirect('/admin');
        if (!is_numeric($link)) redirect('/admin');
        $link = htmlspecialchars($link);
        if ($this->Model->checkSubjectId($link)) {
            $final = $this->Model->deleteSubject($link);
            if (!$final) {
                alerts::SetError("Błąd: Nie usunięto przedmiotu.", 0);
                redirect('/subject/list');
            } else {
                alerts::SetSuccess("Usunięto przedmiot.");
                header('Location: /subject/list');
            }
        } else {
            alerts::SetError("Błąd: Nie usunięto przedmiotu.", 0);
            redirect('/subject/list');
        }
    }

    public function edit($link = NULL)
    {
        $this->is_admin();
        if ($link == NULL) redirect('/admin');
        if (!is_numeric($link)) redirect('/admin');

        $link = htmlspecialchars($link);
        if ($result = $this->Model->checkSubjectId($link)) {
            require 'views/admin/subject/subject.edit.php';
        } else {
            alerts::SetError("Błąd: Nie zmodyfikowano przedmiotu.", 0);
            redirect('/subject/list');
        }
    }

    public function edytuj() {
        $this->is_admin();
        //Init data
        $data = [
            'name' => trim($_POST['name']),
            'id' => trim($_POST['id'])
        ];

        $link = $data['id'];

        //Validate inputs
        if (empty($data['name']) || empty($data['id'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect("/subject/edit/$link");
        }

        if (strlen($data['name']) > 30) {
            alerts::SetError("Nazwa nie może być dłuższa niż 30 znaków.", 0);
            redirect("/subject/edit/$link");
        }

        if (strlen($data['name']) < 4) {
            alerts::SetError("Nazwa nie może być krótsza niż 4 znaki.", 0);
            redirect("/subject/edit/$link");
        }

        $nazwa = $this->Model->checkSubject($data['name']);
        if ($nazwa == true) {
            alerts::SetError("Nazwa przedmiotu jest zajęta.", 0);
            redirect("/subject/edit/$link");
        }

        $data['name'] = htmlspecialchars($data['name']);

        $final = $this->Model->modifySubject($data['id'],$data['name']);
        if (!$final) {
            alerts::SetError("Błąd: Nie zmodyfikowano przedmiotu.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Zmieniono nazwę przedmiotu.");
            header('Location: /subject/list');
        }
    }

}