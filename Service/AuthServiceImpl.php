<?php

require_once  __DIR__ . '/../Dtos/ResponseDto/TokenResponseDto.php';
require_once  __DIR__ . '/../Dtos/RequestDto/LoginRequestDto.php';
require_once  __DIR__ . '/../models/User.php';
class AuthServiceImpl
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }
/** busca usuario por email
 * si no encuentra al usuario o la contraseña es incorrecta arroja una excepcion
 * construye el token
 * retorna el token y el usuario
**/
    public function login(LoginRequestDto $requestDto): TokenResponseDto
    {

        $user = $this->model->findByOne('email', $requestDto->email);

        if (!$user || !password_verify($requestDto->password, $user['password'])) {
            throw new Exception("Credenciales inválidas", 401);
        }

        $token = "token de prueba";
        return new TokenResponseDto($token, [
            'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
            ]
        );
    }

}