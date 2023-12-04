<?php

namespace Controller;

class Ueberuns extends Base_Controller
{

    public function homeAction($parameter)
    {
        // Weiterleitung zur trainingszeitenAction
        $this->ueberunsAction($parameter);
    }
    public function ueberunsAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('UeberUns/ueber_uns.phtml', []);
    }

    public function schattenkampfAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('UeberUns/Schattenkampf.phtml', []);
    }

    public function selbstverteidigungAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('UeberUns/Selbstverteidigung.phtml', []);
    }

    public function WettkampfAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('UeberUns/Wettkampf.phtml', []);
    }

    public function WorkoutAction($parameter)
    {
        session_start();

        echo $this->renderTemplate('UeberUns/Workout.phtml', []);
    }

}