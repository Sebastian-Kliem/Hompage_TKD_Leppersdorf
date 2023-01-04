<?php

namespace Model\Resource\DBQuerys;

use Exception;
use Model\Entitys\EventsModel;
use Model\Entitys\NewsModel;
use Model\Resource\Base;

class NewsDBQuery extends Base
{
    public function getLastEventsForNews(): array
    {
        $newsArray = [];
        try {
            $this->connectDB();
            $query = $this->connection->prepare(
                "Select * from News ORDER BY ID DESC LIMIT 0,5");
            $query->execute();


            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $news = new NewsModel($row['headline'], $row['description']);

                $news->setId($row['id']);

                if ($row['Date']) {
                    $news->setDate($row['Date']);
                }

                if ($row['thumbnail_name'] && $row['thumbnail_data']) {
                    $news->setThumbnailName($row['thumbnail_name']);
                    $news->setThumbnailData($row['thumbnail_data']);
                }

                $newsArray[] = $news;
            }
        } catch (exception $e) {

        }

        return $newsArray;
    }

    public function getNewsDetail($id)
    {
        $news = null;
        try {
            $this->connectDB();
            $query = $this->connection->prepare("Select * from News where id = :id");
            $query->bindParam(':id', $id);
            $query->execute();


            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {

                $news = new NewsModel($row['headline'], $row['description']);

                $news->setId($row['id']);

                $sqlFiles = $this->connection->prepare("Select * from NewsMediaFiles 
                    where foreign_key_news = :Events_foreign_id; ");
                $sqlFiles->bindParam(':Events_foreign_id', $id);
                $sqlFiles->execute();

                $files = [];
                while ($rowFiles = $sqlFiles->fetch(\PDO::FETCH_ASSOC)) {
                    if ($rowFiles['FileData']) {
                        $data = base64_decode($rowFiles['FileData']);

                        file_put_contents("temp/".$rowFiles['Filename'], $data,FILE_APPEND);

                        $files[] = $rowFiles['Filename'];
                    }
                }

                $news->setDocuments($files);
            }

        } catch (exception $e) {

        }
            return $news;
    }

    public function putNewNews(NewsModel $newsModel)
    {
        $date = $newsModel->getDate();
        $headline = $newsModel->getHeadline();
        $description = $newsModel->getDescription();
        $thumbnailArray = $newsModel->getThumbnailUploadArray();

        $thumbnailName = '';
        $thumbnailData = '';
        if ($thumbnailArray['name'] != '') {
            $thumbnailName = $thumbnailArray['name'];
            $thumbnailData = base64_encode(file_get_contents($thumbnailArray['tmp_name']));
        }

        try {
            $this->connectDB();
            $query = $this->connection->prepare(
                "INSERT INTO News (Date, headline, description, thumbnail_name, thumbnail_data) 
                VALUES (:eventdate,:eventname,:description,:thumbnail_name,:thumbnail_data)");

            $query->bindParam(':eventdate', $date);
            $query->bindParam(':eventname', $headline);
            $query->bindParam(':description', $description);
            $query->bindParam(':thumbnail_name', $thumbnailName);
            $query->bindParam(':thumbnail_data', $thumbnailData);

            $query->execute();

            $newId = $this->connection->lastInsertId();

//            if ($newsModel->getDocuments() != []) {
                $queryFiles = $this->connection->prepare(
                    "INSERT INTO NewsMediaFiles (Filename, FileData, foreign_key_news)
                VALUES (:filename,:data,:key)");

                foreach ($newsModel->getDocuments() as $document) {
//                    var_dump($document[0]);
                    if ($document[0]['name'] != ''){
                        $fileDataBase64 = '';
                        if ($document[0]['tmp_name'] != '') {
                            $fileDataBase64 = base64_encode(file_get_contents($document[0]['tmp_name']));
                        }

                        $queryFiles->bindParam(':filename', $document[0]['name']);
                        $queryFiles->bindParam(':data', $fileDataBase64);
                        $queryFiles->bindParam(':key', $newId);

                        $queryFiles->execute();
                    }

                }
//            }
        } catch (exception $e) {
            return false;
        }
        return true;
    }
}