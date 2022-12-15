<?php

namespace Model\Resource\DBQuerys;

use Model\Entitys\EventsModel;
use Model\Resource\Base;

class Events extends Base
{
    public function getEventsNowOrInFuture(): array
    {
        $this->connectDB();
        $query = $this->connection->prepare(
            "Select * from Events where EventDate >= CURDATE() ORDER BY EventDate");
        $query->execute();

        $events = [];
        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $event = new EventsModel($row['Events_id'], $row['EventDate'], $row['Name']);
//            $event->setDescription($row['Description']);
//
//            $id = $row['Events_id'];
//            $sqlFiles = "Select * from Events_Files where Events_foreign_id = '" . $id . "';";
//
//            $dbResultFiles = $this->connectDB()->query($sqlFiles);
//
//            $files = [];
//            while ($rowFiles = $dbResultFiles->fetch(\PDO::FETCH_ASSOC)) {
//                $files[$id] = $rowFiles;
//            }
//
//            $event->setDocuments($files);

            $events[] = $event;
        }
        return $events;
    }

    public function getEventsDetail($id)
    {
        $this->connectDB();
        $query = $this->connection->prepare("Select * from Events where Events_id = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        $event = null;
        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {

            $event = new EventsModel($row['Events_id'], $row['EventDate'], $row['Name']);

            if ($row['Description']) {
                $event->setDescription($row['Description']);
            }


            $Events_foreign_id = $id;
            $sqlFiles = $this->connection->prepare("Select * from Events_Files 
                    where Events_foreign_id = :Events_foreign_id; ");
            $sqlFiles->bindParam(':Events_foreign_id', $Events_foreign_id);
            $sqlFiles->execute();

            $files = [];
            while ($rowFiles = $sqlFiles->fetch(\PDO::FETCH_ASSOC)) {
                $files[] = $rowFiles;
            }

            $event->setDocuments($files);

        }

            return $event;
    }
}