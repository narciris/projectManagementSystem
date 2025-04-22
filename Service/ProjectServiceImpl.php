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

    public function getByUserId($userId) : array
    {
        //validar que el usuario existe
         $this->modelUser->findUserById($userId);

        //validar si hay proyectos del usuario

        $projects = $this->model->findAllByUserId($userId);
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
        //buscar por nombre
        $nameProject = $this->model->findByOne('name', $requestDto->name);
        if($nameProject){
            throw new Exception("El nombre del proyecto no existe", 400);
        }

        //validar si el usuario esta autenticado
        //validar si el usuario tiene permisos para crear un proyecto

        $userId = $requestDto->user_id;
        $this->modelUser->findUserById($userId);

        $data = [
            'name' => $requestDto->name,
            'description' => $requestDto->description,
            'start_date' => $requestDto->startDate,
            'delivery_date' => $requestDto->deliveryDate,
            'user_id' => $userId,
            'file_path' => $requestDto->filePath

        ];

        $insertIdSave = $this->model->save($data);
        return new  ProjectResponseDto($insertIdSave,
        $requestDto->name,
        $requestDto->description,
        $requestDto->startDate,
        $requestDto->deliveryDate,
        $requestDto->user_id,
        $requestDto->filePath
        );

    }



}