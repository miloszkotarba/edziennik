<?php

require_once 'models/student.php';
require_once 'alerts.php';

class Student extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Students();
    }

    public function index()
    {
        $this->is_admin();
        require 'views/admin/student/student.add.php';
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
            'surname' => trim($_POST['surname']),
            'email' => trim($_POST['email']),
            'login' => trim($_POST['login']),
            'password' => trim($_POST['password'])
        ];

        //Validate inputs
        if (empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['login']) || empty($data['password'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/student');
        }

        if (strlen($data['name']) > 60) {
            alerts::SetError("Imię nie może być dłuższe niż 60 znaków.", 0);
            redirect('/student');
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['name'])) {
            alerts::SetError("Podano nieprawidłowe imię.", 0);
            redirect('/student');
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['surname'])) {
            alerts::SetError("Podano nieprawidłowe nazwisko.", 0);
            redirect('/student');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            alerts::SetError("Podano nieprawidłowy adres e-mail.", 0);
            redirect('/student');
        }

        $email = $this->Model->checkUserEmail($data['email']);
        if ($email == true) {
            alerts::SetError("Użytkownik o takim adresie e-mail już istnieje.", 0);
            redirect('/student');
        }

        if (strlen($data['login']) < 5) {
            alerts::SetError("Login musi mieć co najmniej 5 znaków.", 0);
            redirect('/student');
        }


        if (strlen($data['login']) > 50) {
            alerts::SetError("Login nie może być dłuższy niż 50 znaków.", 0);
            redirect('/student');
        }

        if (strlen($data['password']) < 5) {
            alerts::SetError("Hasło musi mieć co najmniej 5 znaków.", 0);
            redirect('/student');
        }


        if (strlen($data['password']) > 50) {
            alerts::SetError("Hasło nie może być dłuższe niż 50 znaków.", 0);
            redirect('/student');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $final = $this->Model->insertStudent($data['name'], $data['surname'], $data['email'], $data['login'], $data['password']);
        if (!$final) {
            alerts::SetError("Błąd: Nie dodano ucznia.", 0);
            redirect('/admin');
        } else {
            alerts::SetSuccess("Dodano ucznia.");
            header('Location: /admin');
        }
    }


}