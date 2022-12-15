<?php

namespace Controller;

use Session\Session;

class Home extends Base_Controller
{
    public function homeAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('home.phtml', []);
    }

    public function impressumAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('impressum.phtml', []);
    }

    public function datenschutzerklaerungAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('datenschutzerklaerung.phtml', []);
    }

    public function logInAction($parameter)
    {
        session_start();

        if ($this->isPost()) {
            if (Session::logIn($_POST['email'], $_POST['password'])){
                header('Location: '. \App::getBaseURL());
            }
        }

        echo $this->renderTemplae('login.phtml', []);
    }

    public function register($parameter)
    {

    }

    public function logout($parameter)
    {

    }
}