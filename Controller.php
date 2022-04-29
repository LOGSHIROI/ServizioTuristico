<?php

namespace Controller;



class Controller
{
    protected $Controllers;
    public function invoke()
    {
        $this->init();
        $controller = $this->getController(parse_url($_SERVER['REQUEST_URI'])["path"]);
        if ($controller == null) {
            $this->HandleUnfoundController();
            return;
        }
        $controllerType = new $controller[0];
        $controllerFunc = $controller[1];
        if (is_callable(array($controllerType, $controllerFunc))) {
            try {
                $controllerType->$controllerFunc();
            } catch (\Exception $exception) {
                echo $exception->getMessage();
                $this->HandleServerError();
            }
        } else {
            $this->HandleServerError();
        }
    }

    protected function getController($requestUri) {
        if (array_key_exists($requestUri, $this->Controllers))
            return $this->Controllers[$requestUri];
        return null;
    }

    protected function init() {
        $this->Controllers = [
            "/questionario" => ["\Controller\QuestionarioController", "index"],
            "/sendmail" => ["\Controller\QuestionarioController", "sendMail"],
        ];
    }

    protected function HandleUnfoundController()
    {
        http_response_code(404);
    }

    protected function HandleServerError()
    {
        http_response_code(500);
    }
}