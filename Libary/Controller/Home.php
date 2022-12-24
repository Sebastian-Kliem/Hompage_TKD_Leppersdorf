<?php

namespace Controller;

use Session\Session;

class Home extends Base_Controller
{
    public function homeAction($parameter)
    {
        session_start();

        if (is_dir('temp')) {
//            if ( $handle = opendir('temp/') )
//            {
//                // einlesen der Verzeichnisses
//                while (($file = readdir($handle)) !== false)
//                {
//                    echo "<li>Dateiname: ";
//                    echo $file;
//
//                    echo "<ul><li>Dateityp: ";
//                    echo filetype( $file );
//                    echo "</li></ul>\n";
//                }
//                closedir($handle);
//            }
            foreach (scandir('temp') as $file) {
                if ($file === ".." or $file === ".") continue;
                var_dump($file);
                echo '<br>';
                var_dump(filemtime('temp/'.$file));

                if ((filemtime('temp/'.$file) + 600) <= time()) {
                    unlink('temp/'.$file);
                    echo '<br>File gelöscht';
                }
                echo '<br>--------------------<br>';
            }

        }

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