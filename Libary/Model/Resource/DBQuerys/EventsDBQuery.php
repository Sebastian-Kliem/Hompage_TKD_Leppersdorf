<?php

namespace Model\Resource\DBQuerys;

use Exception;
use Model\Entitys\EventsModel;
use Model\Resource\Base;

class EventsDBQuery extends Base
{
    public function getEventsNowOrInFuture(): array
    {
        $events = [];
        try {
            $this->connectDB();
            $query = $this->connection->prepare(
                "Select * from Events where EventDate >= CURDATE() ORDER BY EventDate");
            $query->execute();

            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $event = new EventsModel($row['EventDate'], $row['EventName']);
                $event->setId($row['Events_id']);
                $events[] = $event;
            }

        } catch (exception $e) {

        }
        return $events;
    }

    public function getEventsDetail($id)
    {
        $event = null;

        try {
            $this->connectDB();
            $query = $this->connection->prepare("Select * from Events where Events_id = :id");
            $query->bindParam(':id', $id);
            $query->execute();


            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {

                $event = new EventsModel($row['EventDate'], $row['EventName']);

                $event->setId($row['Events_id']);

                if ($row['EventDescription']) {
                    $event->setDescription($row['EventDescription']);
                }

                $sqlFiles = $this->connection->prepare("Select * from Events_Files 
                    where Events_foreign_id = :Events_foreign_id; ");
                $sqlFiles->bindParam(':Events_foreign_id', $id);
                $sqlFiles->execute();

                $files = [];
                while ($rowFiles = $sqlFiles->fetch(\PDO::FETCH_ASSOC)) {

                    $data = base64_decode($rowFiles['Data']);

                    if ($rowFiles['Filename'] != '') {
                        file_put_contents("temp/" . $rowFiles['Filename'], $data, FILE_APPEND);

                        $files[] = $rowFiles['Filename'];
                    }

                }

                $event->setDocuments($files);
            }
        } catch (exception $e) {

        }
            return $event;
    }

    public function putNewEvent(EventsModel $eventModel)
    {
        $date = $eventModel->getDate();
        $name = $eventModel->getName();
        $description = $eventModel->getDescription();

        try {
            $this->connectDB();
            $query = $this->connection->prepare(
                "INSERT INTO Events (EventDate, EventName, EventDescription) 
                VALUES (:eventdate,:eventname,:eventdescription)");

            $query->bindParam(':eventdate', $date);
            $query->bindParam(':eventname', $name);
            $query->bindParam(':eventdescription', $description);

            $query->execute();

            $newId = $this->connection->lastInsertId();

            $queryFiles = $this->connection->prepare(
                "INSERT INTO Events_Files (Filename, Data, Events_foreign_id)
                VALUES (:filename,:data,:key)");

            if ($eventModel->getDocuments() !== []) {
                foreach ($eventModel->getDocuments() as $document) {
                    $fileDataBase64 = '';
                    if ($document['tmp_name'] != '') {
                        $fileDataBase64 = base64_encode(file_get_contents($document['tmp_name']));
                    }

                    $queryFiles->bindParam(':filename', $document['name']);
                    $queryFiles->bindParam(':data', $fileDataBase64);
                    $queryFiles->bindParam(':key', $newId);

                    $queryFiles->execute();
                }
            }
        } catch (exception $e) {
            return false;
        }
        return true;
    }
}