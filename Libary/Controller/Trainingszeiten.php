<?php

namespace Controller;

class Trainingszeiten extends Base_Controller
{
    public function trainingszeitenAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('trainingszeiten.phtml', []);
    }



}