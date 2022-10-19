<?php

namespace Controller;

class Ueberuns extends Base_Controller
{
    public function ueberunsAction($parameter)
    {
        echo $this->renderTemplae('UeberUns/ueber_uns.phtml', []);
    }

    public function schattenkampfAction($parameter)
    {
        echo $this->renderTemplae('UeberUns/Schattenkampf.phtml', []);
    }

    public function selbstverteidigungAction($parameter)
    {
        echo $this->renderTemplae('UeberUns/Selbstverteidigung.phtml', []);
    }

    public function WettkampfAction($parameter)
    {
        echo $this->renderTemplae('UeberUns/Wettkampf.phtml', []);
    }

    public function WorkoutAction($parameter)
    {
        echo $this->renderTemplae('UeberUns/Workout.phtml', []);
    }

}