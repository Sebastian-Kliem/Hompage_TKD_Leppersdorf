<?php

namespace Controller;

use App;
use Model\Entitys\EventsModel;
use Model\Resource\DBQuerys\Events;

class News extends Base_Controller
{
    public function newsAction($parameter)
    {
        echo $this->renderTemplae('news.phtml', []);
    }
}