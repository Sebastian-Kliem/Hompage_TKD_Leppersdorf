<?php

namespace Controller;


class Info extends Base_Controller
{
    public function infoAction($parameter)
    {
        phpinfo();
//        echo $this->renderTemplae('login.phtml', []);
    }
}