<?php

namespace Controller;

class Trainingszeiten extends Base_Controller
{
    public function trainingszeitenAction($parameter)
    {
        echo $this->renderTemplae('trainingszeiten.phtml', []);
    }



}