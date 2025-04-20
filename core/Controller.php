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

    public function jsonError($message, $status = 400)
    {
       $this->jsonResponse([
           'status' => 'error',
           'status_code' => $status,
           'message' => 'error al realizar la operacion',
           "error" => $message
       ], $status);
    }

    public function jsonResponse($data, $status = 200){
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit();

    }

    public function jsonSuccess($data, $status = 200)
    {
       $this->jsonResponse([
           'status' => 'success',
           'status_code' => $status,
           'message' => 'Operacion realizada con exito',
           'data' => $data,

       ], $status);
    }

    public function render($location)
    {
        header('Location: ' . $location);
        exit;
    }

}