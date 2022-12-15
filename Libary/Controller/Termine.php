<?php

namespace Controller;

use App;
use Model\Entitys\EventsModel;
use Model\Resource\DBQuerys\Events;

class Termine extends Base_Controller
{

    public function overviewAction($parameter)
    {
        $events = new Events();
        $eventsArray = $events->getEventsNowOrInFuture();

        echo $this->renderTemplae('EventsOverview.phtml', ['events' => $eventsArray]);
    }

    public function detailsAction($parameter)
    {
//        var_dump($parameter['id']);
        $event = new Events();
        $eventArray = $event->getEventsDetail($parameter['id']);

        echo $this->renderTemplae('EventsDetails.phtml', ['events' => $eventArray]);
    }
}