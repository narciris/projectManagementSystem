<?php
require_once  __DIR__ . '/../Dtos/RequestDto/LoginRequestDto.php';
require_once  __DIR__ . '/../Dtos/ResponseDto/TokenResponseDto.php';
require_once  __DIR__ . '/../Service/AuthServiceImpl.php';
class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthServiceImpl();
    }

    public function login() : TokenResponseDto{


        try{
            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset( $data['email']) || !isset($data['password']))
            {
                throw new Exception("datos incompletos",400);
            }
            $loginRequest = new LoginRequestDto($data['email'], $data['password']);

            $response = $this->authService->login($loginRequest);
//            var_dump($response);
            $this->jsonSuccess($response);
            exit();

        }catch (Exception $e){
           $this->jsonError($e->getCode(), $e->getMessage());
            return new TokenResponseDto("error",["message",$e->getMessage() ]);
        }
    }
}