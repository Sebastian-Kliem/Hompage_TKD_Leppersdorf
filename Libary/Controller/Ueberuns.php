<?php

namespace Controller;

class Ueberuns extends Base_Controller
{
    public function ueberunsAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('UeberUns/ueber_uns.phtml', []);
    }

    public function schattenkampfAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('UeberUns/Schattenkampf.phtml', []);
    }

    public function selbstverteidigungAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('UeberUns/Selbstverteidigung.phtml', []);
    }

    public function WettkampfAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('UeberUns/Wettkampf.phtml', []);
    }

    public function WorkoutAction($parameter)
    {
        session_start();

        echo $this->renderTemplae('UeberUns/Workout.phtml', []);
    }

}