<?php

namespace Controller;

use View\Tamplate;

class Base_Controller
{
    public function renderTemplae(string $template, array $data)
    {
        $view = new Tamplate($template);
        return $view->renderTamplate($data);
    }

    public function isPost()
    {
        if (count($_POST) > 0) {
            return true;
        }
        return false;
    }
}