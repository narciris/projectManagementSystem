<?php

require_once __DIR__ . '/../models/User.php';
class UserServiceImpl
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function register(){

    }

    public function getUserById($id) :UserResponseDto
    {
        $model = $this->model;
        $user = $model->findById($id);

        if(!$user){
            throw new  Exception("Usuario no encontrado", 404);
        }
    return new UserResponseDto($user['id'],$user['name'],$user['email']);

    }
/**
 * obtiene la respuesta del metodo findall en la variable users
 * lo guarda en un array, por cada usuario traido de la base de datos,
 * lo convierte en un userDto
 * y devuelve un array de objetos UserDto
**/
    public function getAllUsers()
    {
        $model = $this->model;
        $users = $model->findAll();

        $userDto = [];

        foreach ($users as $user){
            $userDto[] = new UserResponseDto($user['id'],$user['name'],$user['email']);
        }
        return $userDto;
    }


}