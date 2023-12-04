<?php

namespace Controller;

use Model\Resource\DBQuerys\UsersDBQuery;
use Session\Session;

class Home extends Base_Controller
{
    public function homeAction($parameter)
    {
        session_start();

        $this->deleteTempFiles();

        echo $this->renderTemplate('home.phtml', []);
    }

    public function impressumAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('impressum.phtml', []);
    }

    public function datenschutzerklaerungAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('datenschutzerklaerung.phtml', []);
    }

    public function logInAction($parameter)
    {
        session_start();

        if ($this->isPost()) {
            if (isset($_POST['email'])) {
                if (Session::logIn($_POST['email'], $_POST['password'])){
                    header('Location: '. \App::getBaseURL());
                }
            } elseif (isset($_POST['register_email'])) {
               $dbQuery = new UsersDBQuery();
               if ($dbQuery->register($_POST['register_email'], $_POST['register_username'], $_POST['register_password'])){
                   echo $this->renderTemplate('login.phtml', ['register' => true]);
               } else {
                   echo $this->renderTemplate('login.phtml', ['register' => false]);
               }
            }
        }
        echo $this->renderTemplate('login.phtml', []);
    }

    public function logoutAction($parameter)
    {
        session_start();
        $_SESSION = [];
        echo $this->renderTemplate('logout.phtml', ['logout' => true]);
    }

    private function deleteTempFiles()
    {
        if (is_dir('temp')) {
            foreach (scandir('temp') as $file) {
                if ($file === ".." or $file === ".") {
                    continue;
                }

                if ((filemtime('temp/' . $file) + 600) <= time()) {
                    unlink('temp/' . $file);
                }
            }
        }
    }
}