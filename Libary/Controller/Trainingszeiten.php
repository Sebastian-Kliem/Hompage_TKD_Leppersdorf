<?php

namespace Controller;

class Trainingszeiten extends Base_Controller
{
    public function homeAction($parameter)
    {
        // Weiterleitung zur trainingszeitenAction
        $this->trainingszeitenAction($parameter);
//        header('Location: '. \App::getBaseURL()."trainingszeiten/trainingszeiten");
    }
    public function trainingszeitenAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('trainingszeiten.phtml', []);
    }



}