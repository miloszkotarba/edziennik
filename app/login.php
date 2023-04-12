<?php

require_once 'models/users.php';
require_once 'alerts.php';

class Login extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function index()
    {
        $this->is_logged();
        require_once 'app/views/login.view.php';
    }

    public function is_logged()
    {
        if(isset($_SESSION['usersId'])) {
            header('Location: /dashboard');
            exit();
        }
    }

    public function check()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'user' => trim($_POST['user']),
            'password' => trim($_POST['password'])
        ];

        //Validate inputs
        if (empty($data['user']) || empty($data['password'])) {
            alerts::SetError("Uzupełnij wszystkie pola.", 0);
            redirect('/login');
        }

        if ($this->userModel->findUserByLogin($data['user'])) {
            //User Found
            $loggedInUser = $this->userModel->login($data['user'], $data['password']);
            if ($loggedInUser) {
                //Create session
                $this->createUserSession($loggedInUser);
            } else {
                alerts::SetError("Niepoprawny login lub hasło", 0);
                redirect('/login');
            }
        } else {
            alerts::SetError("Niepoprawny login lub hasło", 0);
            redirect('/login');
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['usersId'] = $user->usersId;
        $_SESSION['usersName'] = $user->usersName;
        $_SESSION['usersSurname'] = $user->usersSurname;
        $_SESSION['usersRole'] = $user->usersRole;
        redirect('/dashboard');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $_SESSION = array();
        redirect('/home');
    }
}