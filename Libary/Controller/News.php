<?php

namespace Controller;

class News extends Base_Controller
{
    public function newsAction($parameter)
    {
        echo $this->renderTemplae('news.phtml', []);
    }
}