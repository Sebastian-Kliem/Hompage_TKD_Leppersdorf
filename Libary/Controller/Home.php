<?php

namespace Controller;

use Session\Session;

class Home extends Base_Controller
{
    public function homeAction($parameter)
    {
        session_start();

        var_dump(password_hash('testpassword', PASSWORD_DEFAULT));

        $this->deleteTempFiles();

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