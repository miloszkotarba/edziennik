<?php

require_once 'models/teacher.php';
require_once 'models/categories.php';
require_once 'alerts.php';

class Teacher extends Controller
{
    private $Model;

    public function __construct()
    {
        $this->Model = new Teachers();
        $this->KategorieModel = new Category();
    }

    public function index()
    {
        $this->is_admin();
        $result = $this->Model->showAllTeachers();
        require 'views/admin/teacher/teacher.list.php';
    }

    public function add()
    {
        $this->is_admin();
        require 'views/admin/teacher/teacher.add.php';
    }

    public function dodaj()
    {
        $this->is_admin();
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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
            redirect('/teacher/add');
        }

        if (strlen($data['name']) > 60) {
            alerts::SetError("Imię nie może być dłuższe niż 60 znaków.", 0);
            redirect('/teacher/add');
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['name'])) {
            alerts::SetError("Podano nieprawidłowe imię.", 0);
            redirect('/teacher/add');
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['surname'])) {
            alerts::SetError("Podano nieprawidłowe nazwisko.", 0);
            redirect('/teacher/add');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            alerts::SetError("Podano nieprawidłowy adres e-mail.", 0);
            redirect('/teacher/add');
        }

        $email = $this->Model->checkUserEmail($data['email']);
        if ($email == true) {
            alerts::SetError("Użytkownik o takim adresie e-mail już istnieje.", 0);
            redirect('/teacher/add');
        }

        if (strlen($data['login']) < 5) {
            alerts::SetError("Login musi mieć co najmniej 5 znaków.", 0);
            redirect('/teacher/add');
        }


        if (strlen($data['login']) > 50) {
            alerts::SetError("Login nie może być dłuższy niż 50 znaków.", 0);
            redirect('/teacher/add');
        }

        if (strlen($data['password']) < 5) {
            alerts::SetError("Hasło musi mieć co najmniej 5 znaków.", 0);
            redirect('/teacher/add');
        }


        if (strlen($data['password']) > 50) {
            alerts::SetError("Hasło nie może być dłuższe niż 50 znaków.", 0);
            redirect('/teacher/add');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $final = $this->Model->insertTeacher($data['name'], $data['surname'], $data['email'], $data['login'], $data['password']);
        if (!$final) {
            alerts::SetError("Błąd: Nie dodano nauczyciela.", 0);
            redirect('/teacher/add');
        } else {

            ///dodanie kategorii predefiniowanych
            $newTeacherId = $this->Model->showUserId($data['email']);
            $newTeacherId = $newTeacherId->usersId;

            $this->KategorieModel->insertCategory("przewidywana śródroczna", 0, "b0c4de", 0, $newTeacherId);
            $this->KategorieModel->insertCategory("śródroczna", 0, "b0c4de", 0, $newTeacherId);
            $this->KategorieModel->insertCategory("przewidywana roczna", 0, "87cefa", 0, $newTeacherId);
            $this->KategorieModel->insertCategory("roczna", 0, "87cefa", 0, $newTeacherId);


            alerts::SetSuccess("Dodano nauczyciela.");
            header('Location: /teacher');
        }
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

    public function delete($link = NULL)
    {
        $this -> is_admin();
        if ($link == NULL) {
            redirect('/teacher');
        }

        $teacherId = $link;

        $warunek = $this->Model->checkIfTeacherCanBeDeleted($teacherId);
        if ($warunek) {
            $final = $this->KategorieModel->deleteAllCategories($teacherId);
        }

        $final2 = $this->Model->deleteTeacher($teacherId);

        if (!$final2) {
            alerts::SetError("Błąd. Nie można usunąć przypisanego nauczyciela.");
            redirect('/teacher');
        } else {
            alerts::SetSuccess("Usunięto nauczyciela.");
            redirect('/teacher');
        }
    }

    public function edit($link = NULL)
    {
        $this->is_admin();

        if ($link == NULL) {
            redirect('/teacher');
        }

        $final = $this->Model->getTeacherById($link);
        if (!$final) {
            redirect('/teacher');
        }

        require 'views/admin/teacher/teacher.edit.php';
    }

    public function edytuj()
    {
        $this->is_admin();
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'name' => trim($_POST['name']),
            'surname' => trim($_POST['surname']),
            'email' => trim($_POST['email']),
            'login' => trim($_POST['login']),
            'password' => trim($_POST['password']),
            'usersId' => trim($_POST['usersId'])
        ];


        $link = '/teacher/edit/' . $data['usersId'];

        //Validate inputs
        if (empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['login']) || empty($data['password'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect($link);
        }

        if (strlen($data['name']) > 60) {
            alerts::SetError("Imię nie może być dłuższe niż 60 znaków.", 0);
            redirect($link);
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['name'])) {
            alerts::SetError("Podano nieprawidłowe imię.", 0);
            redirect($link);
        }

        $condition = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        if (!preg_match($condition, $data['surname'])) {
            alerts::SetError("Podano nieprawidłowe nazwisko.", 0);
            redirect($link);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            alerts::SetError("Podano nieprawidłowy adres e-mail.", 0);
            redirect($link);
        }


        if (strlen($data['login']) < 5) {
            alerts::SetError("Login musi mieć co najmniej 5 znaków.", 0);
            redirect($link);
        }


        if (strlen($data['login']) > 50) {
            alerts::SetError("Login nie może być dłuższy niż 50 znaków.", 0);
            redirect($link);
        }

        if (strlen($data['password']) < 5) {
            alerts::SetError("Hasło musi mieć co najmniej 5 znaków.", 0);
            redirect($link);
        }


        if (strlen($data['password']) > 50) {
            alerts::SetError("Hasło nie może być dłuższe niż 50 znaków.", 0);
            redirect($link);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $final = $this->Model->modifyTeacher($data['usersId'], $data['name'], $data['surname'], $data['email'], $data['login'], $data['password']);
        if (!$final) {
            alerts::SetError("Błąd: Nie zmodyfikowano nauczyciela.");
            redirect('/teacher');
        } else {
            alerts::SetSuccess("Zmodyfikowano konto nauczyciela.");
            redirect('/teacher');
        }
    }
}