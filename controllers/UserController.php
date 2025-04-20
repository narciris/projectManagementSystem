<?php
//import
require_once  __DIR__ . '/../Dtos/RegisterRequestDto.php';
require_once __DIR__ . '/../Dtos/ResponseDto/UserResponseDto.php';
require_once  __DIR__ . '/../Service/UserServiceImpl.php';
class UserController extends Controller
{

    private $userService;

    public function __construct(

    ){

  $this->userService = new UserServiceImpl();
    }
/**
 * Obtenes el array de usuarios de tipo UserResponse
 * recorremos el array y lo convertimos con el metodo toArray para ser pasado a respuesta json
 * si no hay usuarios simplemente se devuelve el array vacio
**/
    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();

           if($users && (count($users) > 0)){

               $response = [];

               foreach ($users as $userDto){
                   $response [] = $userDto->toArray();
               }
               $this->jsonResponse($response);
           }

           $this->jsonSuccess($response);

        } catch (Exception $e) {
            $this->jsonError($e->getMessage(), 400);
        }

    }

    public function show(): void
    {
        try {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                throw new Exception("Error: id no proporcionado", 400);
            }
          $userDto =  $this->userService->getUserById($id);
            $this->jsonSuccess($userDto->toArray());

        } catch (Exception $e) {
            $this->jsonError($e->getMessage(), $e->getCode());
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