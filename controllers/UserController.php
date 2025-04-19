<?php
//import
require_once  __DIR__ . '/../Dtos/RegisterRequestDto.php';
require_once __DIR__ . '/../Dtos/ResponseDto/UserResponseDto.php';
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

    public function show() : UserResponseDto
    {
        try{
            $id = (isset($_GET['id'])) ? $_GET['id'] : false;
            if($id){
                $model = $this->loadModel('User');
                $user = $model->findById($id);

                if($user){
                    $userDto = new  UserResponseDto($user['id'],$user['name'],$user['email']);
                    $this->jsonSuccess($userDto->toArray());
                } else{
                    $this->jsonError('Error');
                }
            } else {
                $this->jsonError('Error: id no proporcionado');
            }
        } catch (Exception $e){
            $this->jsonError($e->getCode(), $e->getMessage());
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
            if($result instanceof  UserResponseDto){
                $this->jsonSuccess($result);
            } else{
                $this->jsonError($result);
            }
        }catch (Exception $e){
            $this->jsonError($e->getMessage(),400);
        }


    }


}