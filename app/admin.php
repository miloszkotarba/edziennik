<?php

require_once 'alerts.php';

class Admin extends Controller
{
    private $Model;

    public function __construct()
    {

    }

    public function index()
    {
        $this->is_admin();
        require 'views/admin/index.view.php';
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

}