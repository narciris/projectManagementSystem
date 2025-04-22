<?php

//import
require_once  __DIR__ . '/../Service/ProjectServiceImpl.php';
require_once  __DIR__ . '/../Dtos/ResponseDto/ProjectResponseDto.php';
require_once  __DIR__ . '/../Dtos/RequestDto/ProjectRequestDto.php';
require_once  __DIR__ . '/../Service/FileService.php';
require_once __DIR__ . '/../core/AuthMiddleware.php';

class ProjectController extends Controller
{
    private $projectService;
    public function __construct()
    {
        $this->projectService = new ProjectServiceImpl();
    }



    public function getByUser($id)
    {
        try {
            $userAuthenticate = AuthMiddleware::authenticate();
            if(!$userAuthenticate)
            {
                throw new Exception("usuario no autenticado");
            }
            $projects = $this->projectService->getByUserId($id);


            $response = [];

            foreach ($projects as $project) {
                $response[] = $project->toArray();
            }

            $this->jsonSuccess($response);

        } catch (Exception $e) {
             $this->jsonError(
                $e->getMessage() ?: "No se encontraron proyectos para este usuario",
                $e->getCode() ?: 404
            );
        }
    }
public function create()

{
    $userAuthenticate = AuthMiddleware::authenticate();
    if(!$userAuthenticate)
    {
        throw new Exception("usuario no autenticado");
    }
    $filePath = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileService = new FileService();
        try {
            $filePath = $fileService->uploadFile(
                $_FILES['file'],
                'uploads/projects'
            );
        } catch (Exception $e) {
            $this->jsonError($e->getMessage(), $e->getCode());
            return;
        }
    }
    foreach (['name', 'description', 'start_date', 'delivery_date', 'user_id'] as $field) {
        if (!isset($_POST[$field])) {
            throw new Exception("El campo '$field' es obligatorio", 422);
        }
    }
    $requestDto = new ProjectRequestDto(
        $_POST['name'],
        $_POST['description'],
        $_POST['start_date'],
        $_POST['delivery_date'],
        $_POST['user_id'],
        $filePath
    );
    try {
        $result = $this->projectService->create($requestDto);
        $this->jsonSuccess($result);

    }catch (Exception $e) {
        $this->jsonError($e->getMessage(), $e->getCode());
    }
}


}