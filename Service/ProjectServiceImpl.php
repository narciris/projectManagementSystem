<?php

//import

require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/User.php';
require_once  __DIR__ . '/../Dtos/RequestDto/ProjectRequestDto.php';


class ProjectServiceImpl
{
    private $model = 'users';
    private $modelUser;

    function __construct()
    {
        $this->model = new Project();
        $this->modelUser = new User();
    }

    public function getByUserId() : array
    {
        $userDat = AuthMiddleware::authenticate();
        if(!$userDat){
            throw new Exception("usuario no autenticado",401);
        }
        $authenticateUserId = $userDat['id'];

        //validar que el usuario existe
         $this->modelUser->findUserById($authenticateUserId);

        //validar si hay proyectos del usuario

        $projects = $this->model->findAllByUserId($authenticateUserId);
        if(!$projects){
            throw new  Exception("No se encontraron proyectos para este usuario", 404);

        }

        $allProject = [];
        foreach ($projects as $project) {
            $allProject[] = new ProjectResponseDto(
                $project['id'],
                $project['name'],
                $project['start_date'],
                $project['description'],
                $project['delivery_date'],
                $project['user_id'],
                $project['file_path']
            );
        }
        return $allProject;

    }

    /**
     * metodo para crear un nuevo proyecto
    **/
    public function create(ProjectRequestDto $requestDto) : ProjectResponseDto
    {
        $userDat = AuthMiddleware::authenticate();
        if(!$userDat){
            throw new Exception("usuario no autenticado",401);
        }
        $authenticateUserId = $userDat['id'];

        //buscar por nombre
        $nameProject = $this->model->findByOne('name', $requestDto->name);
        if(!empty($nameProject)){
            throw new Exception("El nombre del proyecto ya existe", 400);
        }

        $this->modelUser->findUserById($authenticateUserId);

        $data = [
            'name' => $requestDto->name,
            'description' => $requestDto->description,
            'start_date' => $requestDto->startDate,
            'delivery_date' => $requestDto->deliveryDate,
            'user_id' => $authenticateUserId,
            'file_path' => $requestDto->filePath

        ];
//validaciones pendientes:
        //la fecha de inicio no puede ser mayor  a la fecha de entrega
        $insertIdSave = $this->model->save($data);
        return new  ProjectResponseDto($insertIdSave,
        $requestDto->name,
        $requestDto->description,
        $requestDto->startDate,
        $requestDto->deliveryDate,
        $requestDto->$authenticateUserId,
        $requestDto->filePath
        );

    }


    public function updateProject($projectId, PRojectRequestDto $requestDto) : ProjectResponseDto
    {
        $userDat = AuthMiddleware::authenticate();
        if(!$userDat){
            throw new Exception("usuario no autenticado",401);
        }

        $project = $this->model->findById($projectId);
        if(!$project){
            throw new Exception("proyecto no encontrado");
        }


        if(isset($requestDto->name) && trim($requestDto->name) != ''){
            $this->validateName($requestDto->name,$projectId);
            $project->name = $requestDto->name;
        }
        if(isset($requestDto->description) && trim($requestDto->description) != ''){
            $project->description = $requestDto->description;
        }
        if(isset($requestDto->startDate) && trim($requestDto->startDate) != ''){
            $project->start_date = $requestDto->startDate;
        }

        if(isset($requestDto->deliveryDate) && trim($requestDto->deliveryDate) != ''){
            $project->delivery_date = $requestDto->deliveryDate;
        }

        if(isset($requestDto->filePath) && trim($requestDto->filePath) != ''){
            $project->file_path = $requestDto->filePath;
        }

        $this->model->save($project);

        return new ProjectResponseDto(
            $project->id,
            $project->name,
            $project->description,
            $project->start_date,
            $project->delivery_date,
            $project->user_id,
            $project->file_path
        );


    }

    public function validateName($name, $projectId)
    {
        if(empty($name)){
            throw new Exception("el nombre no puede estar vacio");
        }
        $existProject = $this->model->findByOne("name", $name);
        if($existProject && $existProject->id != $projectId){
            throw new Exception("el nombre ya existe");
        }
    }



}