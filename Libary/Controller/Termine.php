<?php

namespace Controller;

use App;
use Model\Entitys\EventsModel;
use Model\Resource\DBQuerys\EventsDBQuery;

class Termine extends Base_Controller
{

    public function overviewAction($parameter)
    {
        session_start();

        if ($this->isPost()) {

            $filesupload = [];
            if(!empty($_FILES)) {
                $filesupload = App::normalize_Postfiles_array($_FILES);
            }

            $eventModel = new EventsModel($_POST['date'], $_POST['name']);
            $eventModel->setDescription(nl2br($_POST['description']));
            $eventModel->setDocuments($filesupload['file']);

            $eventsDBQuery = new EventsDBQuery();
            $response = $eventsDBQuery->putNewEvent($eventModel);

            header('Location: '. \App::getBaseURL()."termine/overview");
        }

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }

        $events = new EventsDBQuery();
        $eventsArray = $events->getEventsNowOrInFuture();

//        if ($eventsArray == []) {
//            echo $this->renderTemplae('dbError.phtml', []);
//        } else {
            echo $this->renderTemplae('EventsOverview.phtml', ['events' => $eventsArray, 'canEdit' => $canEdit]);
//        }
    }

    public function detailsAction($parameter)
    {
        session_start();

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }

        $event = new EventsDBQuery();
        $eventArray = $event->getEventsDetail($parameter['id']);

        if ($eventArray == null) {
            echo $this->renderTemplae('dbError.phtml', []);
        } else {
            echo $this->renderTemplae('EventsDetails.phtml', ['events' => $eventArray, 'canEdit' => $canEdit]);
        }
    }
}