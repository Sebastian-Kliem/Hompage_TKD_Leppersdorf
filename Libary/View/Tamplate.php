<?php

namespace View;

class Tamplate
{
    protected $template = null;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function renderTamplate(array $data)
    {
        extract($data);

        ob_start();
        require_once BASEPATH . "/Templates/" . $this->template;
        $return = ob_get_contents();
        ob_clean();
        return $return;

    }
}