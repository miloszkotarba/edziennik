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

    public function dodaj()
    {
        $this->is_teacher();
        require 'views/ogloszenia/teacher.add.php';
    }

    public function add()
    {
        $this->is_teacher();

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'title' => trim($_POST['Title']),
            'content' => trim($_POST['Content'])
        ];

        //Validate inputs
        if (empty($data['title']) || empty($data['content'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/ogloszenia/dodaj');
        }

        if (strlen($data['title']) > 100) {
            alerts::SetError("Tytuł nie może być dłuższy niż 100 znaków.", 0);
            redirect('/ogloszenia/dodaj');
        }

        if (strlen($data['title']) < 6) {
            alerts::SetError("Tytuł nie może być krótszy niż 6 znaków.", 0);
            redirect('/ogloszenia/dodaj');
        }

        if (strlen($data['title']) > 100) {
            alerts::SetError("Tytuł nie może być dłuższy niż 100 znaków.", 0);
            redirect('/ogloszenia/dodaj');
        }

        if (strlen($data['title']) > 6000) {
            alerts::SetError("Ogłoszenie nie może być dłuższe niż 6000 znaków.", 0);
            redirect('/ogloszenia/dodaj');
        }

        $data['title'] = htmlspecialchars($data['title']);
        $data['content'] = htmlspecialchars($data['content']);

        $user_id = $_SESSION['usersId'];

        $final = $this->Model->insertAnnouncement($data['title'], $data['content'], $user_id);
        if (!$final) {
            alerts::SetError("Błąd. Nie dodano ogłoszenia", 0);
            redirect('/ogloszenia/dodaj');
        } else {
            alerts::SetSuccess("Dodano ogłoszenie");
            header('Location: /ogloszenia/lista');
        }
    }

    public function usun($link = NULL) {
        $this->is_teacher();
        if ($link == NULL) redirect('/ogloszenia/lista');
        $id_user = $_SESSION['usersId'];
        if (!$this->Model->checkAnnouncementOwner($id_user, $link)) {
            alerts::SetError("Nastąpił błąd. Nie usunięto ogłoszenia.");
            redirect('/ogloszenia/lista');
        } else {
            $final = $this->Model->deleteAnnouncement($link);
            if ($final) {
                alerts::SetSuccess("Usunięto ogłoszenie.");
                header('Location: /ogloszenia/lista');
            } else {
                alerts::SetError("Nastąpił błąd. Nie usunięto ogłoszenia.");
                redirect('/ogloszenia/lista');
            }
        }
    }

}