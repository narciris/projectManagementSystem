<?php


class Controller
{
    protected $view;
    protected $models;

    public function loadModel($model)
    {
        $modelFile = 'models/' . $model . '.php';
        if(file_exists($modelFile)){
            require_once $modelFile;
            $modelClass = new $model();
            return $modelClass;
        }else{
            die("el modelo . $model no existe");
        }
    }

    public function loadView($view, $data = array()){

        extract($data);
        $viewFile = 'views/' . $view . '.php';
        if(file_exists($viewFile)){
            require_once $viewFile;

        }else {
            die(" la vista $view no existe");
        }

    }

    public function render($location)
    {
        header('Location: ' . $location);
        exit;
    }

}