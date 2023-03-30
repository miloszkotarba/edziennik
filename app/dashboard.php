<?php

require_once 'alerts.php';

class Dashboard extends Controller
{
    public function index()
    {
        $this->is_logged();
        require 'views/dashboard.view.php';
    }

    public function is_logged()
    {
        if(!isset($_SESSION['usersId'])) {
            header('Location: /home');
            exit();
        }
    }
}