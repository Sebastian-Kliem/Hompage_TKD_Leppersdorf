<?php

namespace Controller;

use App;
use Model\Entitys\NewsModel;
use Model\Resource\DBQuerys\NewsDBQuery;

class News extends Base_Controller
{
    public function newsAction($parameter)
    {
        echo $this->renderTemplae('news.phtml', []);
    }

    public function overviewAction($parameter)
    {


        session_start();

        if ($this->isPost()) {

            // sort $_Files array
            $filesupload = [];
            if(!empty($_FILES)) {
                $filesupload = App::normalize_Postfiles_array($_FILES);
            }

            $newsModel = new NewsModel($_POST['headline'], nl2br($_POST['description']));

            // resize Uploadet JPG and cast it to WebP
            if ($filesupload !== []) {
                $thumbnailData = $this->resizeImages($filesupload['files'][0],250);
                $newsModel->setThumbnailUploadArray($thumbnailData[0]);
                unset($filesupload['files'][0]);

                $filesResized = [];
                foreach ($filesupload['files'] as $file) {
                    $filesResized['files'][] = $this->resizeImages($file,800);
                }

                $newsModel->setDocuments($filesResized['files']);

            }

            $newsModel->setDate(date('Y-m-d'));

            $newsDBQuery = new NewsDBQuery();
            $response = $newsDBQuery->putNewNews($newsModel);
//            header('Location: '. \App::getBaseURL()."news/overview");

        }

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }

        $news = new NewsDBQuery();
        $newsArray = $news->getLastEventsForNews();

            echo $this->renderTemplae('NewsOverview.phtml', ['newsArray' => $newsArray, 'canEdit' => $canEdit]);
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

        $newsDBQuery = new NewsDBQuery();
        $newsArray = $newsDBQuery->getNewsDetail($parameter['id']);

        if ($newsArray == null) {
            echo $this->renderTemplae('dbError.phtml', []);
        } else {
            echo $this->renderTemplae('NewsDetails.phtml', ['news' => $newsArray, 'canEdit' => $canEdit]);
        }
    }

    private function resizeImages(array $file, int $newWidth): array
    {

        $metadata = exif_read_data($file['tmp_name']);
        $imageSize = getimagesize($file['tmp_name']);
//        var_dump($file['name']);
//        echo '<br>';
//        var_dump($imageSize);
//        echo '<br>----------------<br>';
//
//        var_dump($metadata);
//        echo '<br>----------------<br>';

        $imageFileType = image_type_to_mime_type($imageSize[2]);

        $newFilePath = $_SERVER['DOCUMENT_ROOT'] . "/temp/" . $file['name'];
        $newTempFilePath = str_replace("jpg", "webp", $newFilePath);
        $newFilePath = str_replace(" ", "_", $newTempFilePath);

        $oldWidth = $imageSize[0];
        $oldHeight = $imageSize[1];

        $imageRatio = $oldWidth / $oldHeight;

        $newHeight = round($newWidth / $imageRatio);

        switch ($imageFileType) {
            case "image/jpeg":
                $imageNew = imagecreatetruecolor ($newWidth, $newHeight);

                $imageOld = imagecreatefromjpeg ($file['tmp_name']);
                imagecopyresampled ($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

                if(!empty($metadata['Orientation'])) {
                    switch($metadata['Orientation']) {
                        case 8:
                            $imageNew = imagerotate($imageNew,90,0);
                            break;
                        case 3:
                            $imageNew = imagerotate($imageNew,180,0);
                            break;
                        case 6:
                            $imageNew = imagerotate($imageNew,-90,0);
                            break;
                    }
                }

                imagewebp ($imageNew, $newFilePath, 50);
                $file["tmp_name"] = $newFilePath;
                $fileName = str_replace("jpg", "webp", $file["name"]);
                $fileName = str_replace(" ", "_", $fileName);
                $file["name"] = $fileName;
                break;
        }

        $file['size'] = filesize($newFilePath);

        return [$file];
    }
}
