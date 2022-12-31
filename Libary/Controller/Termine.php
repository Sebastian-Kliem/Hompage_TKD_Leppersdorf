<?php

namespace Controller;

use App;
use Model\Entitys\EventsModel;
use Model\Resource\DBQuerys\EventsDBQuery;
use Session\Session;

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
            $eventModel->setDescription($_POST['description']);
            $eventModel->setDocuments($filesupload['file']);

            $eventsDBQuery = new EventsDBQuery();
            $eventsDBQuery->putNewEvent($eventModel);
        }

        $events = new EventsDBQuery();
        $eventsArray = $events->getEventsNowOrInFuture();

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }


        echo $this->renderTemplae('EventsOverview.phtml', ['events' => $eventsArray, 'canEdit' => $canEdit]);
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

        echo $this->renderTemplae('EventsDetails.phtml', ['events' => $eventArray, 'canEdit' => $canEdit]);
    }

//    private function normalize_files_array(array $files) {
//
//        $normalized_array = [];
//
//        foreach($files as $index => $file) {
//
//            if (!is_array($file['name'])) {
//                $normalized_array[$index][] = $file;
//                continue;
//            }
//
//            foreach($file['name'] as $idx => $name) {
//                $normalized_array[$index][$idx] = [
//                    'name' => $name,
//                    'type' => $file['type'][$idx],
//                    'tmp_name' => $file['tmp_name'][$idx],
//                    'error' => $file['error'][$idx],
//                    'size' => $file['size'][$idx]
//                ];
//            }
//
//        }
//
//        return $normalized_array;
//
//    }
}