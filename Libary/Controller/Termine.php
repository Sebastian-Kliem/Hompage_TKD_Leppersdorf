<?php

namespace Controller;

use App;
use Model\Entitys\EventsFiles;
use Model\Entitys\EventsModel;
use Model\Resource\DBQuerys\EventsDBQuery;

class Termine extends Base_Controller
{
    public function homeAction($parameter)
    {
        // Weiterleitung zur trainingszeitenAction
        $this->overviewAction($parameter);
    }
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

        if ($eventsArray == []) {
            echo $this->renderTemplate('dbError.phtml', []);
        } else {
            echo $this->renderTemplate('EventsOverview.phtml', ['events' => $eventsArray, 'canEdit' => $canEdit]);
        }
    }

    public function detailsAction($parameter)
    {
        session_start();

        if ($this->isPost()) {

            $filesupload = [];
            if(!empty($_FILES)) {
                $filesupload = App::normalize_Postfiles_array($_FILES);
            }

            $eventFilesModels = [];
            foreach ($filesupload['file'] as $file) {

                $eventFilesModel = new EventsFiles;
                $eventFilesModel->setFilename($file['name']);
                $eventFilesModel->setData(base64_encode(file_get_contents($file['tmp_name'])));
                $eventFilesModel->setEventId($parameter['id']);

                $eventFilesModels[] = $eventFilesModel;
            }

            $eventsDBQuery = new EventsDBQuery();
            $response = $eventsDBQuery->putNewEventDocuments($eventFilesModels);

            header('Location: '. \App::getBaseURL() . "termine/details/id/" . $parameter['id']);
        }

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }

        $eventDB = new EventsDBQuery();
        $event = $eventDB->getEventsDetail($parameter['id']);

        $eventArray = [];

        if ($event == null) {
            echo $this->renderTemplate('dbError.phtml', []);
        } else {

            $eventArray['eventID'] = $event->getId();
            $eventArray['description'] = $event->getDescription();
            $eventArray['name'] = $event->getName();
            $eventArray['date'] = $event->getDate();

            $eventFiles = [];
            foreach ($event->getDocuments() as $document) {

                if ($document->getFilename() != '') {
                    $data = base64_decode($document->getData());
                    file_put_contents("temp/" . $document->getFilename(), $data);
                }

                $eventFile = [
                    'id' => $document->getId(),
                    'filename' => $document->getFilename()
                    ];

                $eventFiles[] = $eventFile;
            }

            $eventArray['documents'] = $eventFiles;

            echo $this->renderTemplate('EventsDetails.phtml', ['events' => $eventArray, 'canEdit' => $canEdit]);
        }
    }

    public function deleteAction($parameter)
    {
        session_start();

        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $event = new EventsDBQuery();
                $eventArray = $event->deleteEvent($parameter['id']);
            }
        }
        header('Location: '. \App::getBaseURL()."termine/overview");
    }

    public function deleteDocumentAction($parameter)
    {
        session_start();

        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {

                var_dump($parameter);
                $event = new EventsDBQuery();
                $eventArray = $event->deleteDocument($parameter['fileid']);
            }
        }
        header('Location: '. \App::getBaseURL()."termine/details/id/". $parameter['eventid']);
    }
}

