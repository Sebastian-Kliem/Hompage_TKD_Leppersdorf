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
}