<?php

namespace Controller;

use Model\Entitys\NewsModel;
use Model\Resource\DBQuerys\NewsDBQuery;

class Kontakt extends Base_Controller
{
    public function kontaktAction($parameter)
    {
        if ($this->isPost()) {

            $massage =  $_POST['message'];

            $response = mail('sebastiankliem.sk@gmail.com',
                'Kontaktanfrage',
                $massage,
                'From: Vorname Nachname <absender@domain.de>'
            );

            var_dump($response);

        }
        echo $this->renderTemplae('kontakt.phtml', []);
    }
}