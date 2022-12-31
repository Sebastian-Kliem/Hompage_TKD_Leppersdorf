<?php

namespace Controller;

use App;
use Model\Entitys\EventsModel;
use Model\Entitys\NewsModel;
use Model\Resource\DBQuerys\EventsDBQuery;
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

            $filesupload = [];
            if(!empty($_FILES)) {
                $filesupload = App::normalize_Postfiles_array($_FILES);
            }

            $newsModel = new NewsModel($_POST['headline'], $_POST['description']);

            if ($filesupload !== []) {
                $newsModel->setThumbnailUploadArray($filesupload['files'][0]);
                unset($filesupload['files'][0]);
                $newsModel->setDocuments($filesupload['files']);
            }
            var_dump($newsModel->getDocuments());

            $newsModel->setDate(date('Y-m-d'));

            $newsDBQuery = new NewsDBQuery();
            $newsDBQuery->putNewNews($newsModel);
        }

        $news = new NewsDBQuery();
        $newsArray = $news->getLastEventsForNews();

        $canEdit = false;
        if ($_SESSION) {
            if ($_SESSION['isModerator'] || $_SESSION['isAdmin']) {
                $canEdit = true;
            }
        }


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
        $news = $newsDBQuery->getNewsDetail($parameter['id']);

        echo $this->renderTemplae('NewsDetails.phtml', ['news' => $news, 'canEdit' => $canEdit]);
    }

}