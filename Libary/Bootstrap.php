<?php

/**
 *
 */


class Bootstrap
{

    private string $_controller;
    private string $_action;
    private array $_parameter = [];

    public function __construct()
    {
        $this->parseRequest();
    }

    private function parseRequest()
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        @list($controller, $action, $parameter) = explode("/", $path, 3);

        $controller = (strlen($controller) > 0) ? $controller : "Home";
        $this->setController($controller);

        $action = (isset($action)) ? $action : "Home";
        $this->setAction($action);

        if (isset($parameter)) {
            $this->setParameter($parameter);
        }

    }

    private function setController($controller)
    {
        $ctrl = sprintf("\\Controller\\%s", ucfirst(strtolower($controller)));
        if (!class_exists($ctrl)) {
            throw new InvalidArgumentException(
                "Controller unbekannt: $ctrl"
            );
        }
        $this->_controller = $ctrl;
    }

    private function setAction($action)
    {
        $actionMethod = sprintf("%sAction", strtolower($action));
        $reflection = new ReflectionClass($this->_controller);
        if (!$reflection->hasMethod($actionMethod)) {
            throw new InvalidArgumentException(
                "Dem Controller $this->_controller ist die Methode $actionMethod unbekannt."
            );
        }
        $this->_action = $actionMethod;
    }

    private function setParameter($parameter)
    {
        $parameterExplodet = explode('/', $parameter);
        if (count($parameterExplodet) % 2 > 0) {
            throw new InvalidArgumentException("Parameteranzahl ungültig");
        }

        $parameterArray = [];
        $lastIndex = 0;
        for ($i = 0; $i < count($parameterExplodet); $i++) {
            if ($i % 2 > 0) {
                $parameterArray[$parameterExplodet[$lastIndex]] = $parameterExplodet[$i];
            }
            $lastIndex = $i;
        }

        $this->_parameter = $parameterArray;
    }


    public function run()
    {
        $controllerObject = new $this->_controller;
        $controllerObject->{$this->_action}($this->_parameter);
    }
}