<?php
require_once  __DIR__ . '/../Dtos/RequestDto/LoginRequestDto.php';
require_once  __DIR__ . '/../Dtos/ResponseDto/TokenResponseDto.php';
require_once  __DIR__ . '/../Service/AuthServiceImpl.php';
require_once __DIR__ . '/../Service/JwtService.php';
class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthServiceImpl();
    }

    public function login() : void{


        try{
            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset( $data['email']) || !isset($data['password']))
            {
                throw new Exception("datos incompletos",400);

            }
            $loginRequest = new LoginRequestDto(
                $data['email'],
                $data['password']);
            $user = $this->authService->login($loginRequest);

            $this->jsonSuccess($user);
            exit();

        }catch (Exception $e){
           $this->jsonError($e->getMessage(),$e->getCode());

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
                $this->jsonSuccess($result,201);
            } else{
                $this->jsonError($result);
            }
        }catch (Exception $e){
            $this->jsonError($e->getMessage(),400);
        }


    }
}