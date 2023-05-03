<?php

class Profile extends Controller
{
    public function index()
    {
        $this->is_logged();
        header('Location: /profile/settings');
    }

    public function settings()
    {
        $this->is_logged();
        require_once 'views/profile.view.php';
    }

    public function photo() {
        $this->is_logged();
        require_once  'views/profile.photo.change.php';
    }

    public function is_logged()
    {
        if (!isset($_SESSION['usersId'])) {
            header('Location: /home');
            exit();
        }
    }
}