<?php

namespace Controller;

class Kontakt extends Base_Controller
{
    public function kontaktAction($parameter)
    {
        echo $this->renderTemplae('kontakt.phtml', []);
    }
}