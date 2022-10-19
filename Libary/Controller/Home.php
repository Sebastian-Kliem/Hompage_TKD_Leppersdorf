<?php

namespace Controller;

class Home extends Base_Controller
{
    public function homeAction($parameter)
    {
        echo $this->renderTemplae('home.phtml', []);
    }

    public function impressumAction($parameter)
    {
        echo $this->renderTemplae('impressum.phtml', []);
    }

    public function datenschutzerklaerungAction($parameter)
    {
        echo $this->renderTemplae('datenschutzerklaerung.phtml', []);
    }


}