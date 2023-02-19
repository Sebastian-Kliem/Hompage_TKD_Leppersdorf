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
        if (count($_POST) > 0 || count($_FILES) > 0) {
            return true;
        }
        return false;
    }

//    Todo: create a filemodel, change the EventFiles.php and NewsFilesModel.php to this
//    Todo: vrate the function saveFileFromDBtoTemp and use it in Termin-detailsAction and News-detailsAction
//    protected function saveFileFromDBtoTemp(Filemodel $file)
}