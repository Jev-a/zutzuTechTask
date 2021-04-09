<?php

namespace ZTT\http;

class Router
{
    private $routs;
    private $result;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $pathPost = ROOT . '/../config/routes.php';
        $this->routs = include($pathPost);
    }

    /**
     *
     */
    public function run()
    {
        $userUrl = $this->getUrl();
        try {
            foreach ($this->routs as $pattern => $path) {
                if (preg_match("~$pattern~", $userUrl)) {
                    $name = explode('/', $path);
                    $controllerName = ucfirst(array_shift($name) . 'Controller');
                    $actionName = array_shift($name) . 'Action';
                    $file = ROOT . '/../app/Controller/' . $controllerName . '.php';

                    if (file_exists($file)) {
                        $class = 'ZTT\app\Controller\\' . $controllerName;
                        $controllerObject = new $class();
                        $this->result = $controllerObject->$actionName();
                    }

                    if ($this->result != null) {
                        break;
                    }
                }
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
}
