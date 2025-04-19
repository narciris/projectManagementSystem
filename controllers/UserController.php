<?php
require_once  __DIR__ . '/../Dtos/RegisterRequestDto.php';
require_once __DIR__ . '/../Dtos/ResponseDto/RegisterResponseDto.php';
class UserController extends Controller
{

    public function __construct(){


    }

    public function index()
    {
       $model = $this->loadModel('User');
       $users = $model->findAll();
       if($users){
           $this->jsonSuccess($users);
       }else{
           $this->jsonError('Error');
       }

    }

    public function show()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : false;
        if($id){
            $model = $this->loadModel('User');
            $user = $model->findById($id);

            if($user){
                $this->jsonSuccess($user);
            } else{
                $this->jsonError('Error');
            }
        } else {
            $this->jsonError('Error: id no proporcionado');
        }
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $dto = new RegisterRequestDto($data['email'],$data['password'],$data['name']);

        try{
            $userModel = $this->loadModel('User');
//            var_dump($userModel); exit;

            $result = $userModel->registerUser($dto);

            header('Content-Type: application/json');
            if($result instanceof  RegisterResponseDto){
                $this->jsonSuccess($result);
            } else{
                $this->jsonError($result);
            }
        }catch (Exception $e){
            $this->jsonError($e->getMessage(),400);
        }


    }


}