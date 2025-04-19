<?php




require_once __DIR__ . '/../core/Connexion.php';
require_once __DIR__ . '/../core/Model.php';
require_once  __DIR__ . '/../Dtos/RegisterRequestDto.php';
require_once __DIR__ . '/../Dtos/ResponseDto/RegisterResponseDto.php';

class User extends Model
{

    protected $model = 'users';


    public function registerUser(RegisterRequestDto $requestDto) : RegisterResponseDto
    {
        $email = $requestDto->getEmail();
        $query = "SELECT COUNT(*) FROM {$this->model} WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if($stmt->fetchColumn()){
            throw new Exception("El email ya esta registrado");
        }

        $data = $requestDto->toArray();
//        var_dump($data); exit;
         $userID = parent::save($data);
//        var_dump($userID);
         if(!$userID){
             throw new Exception("Error al registrar un usuario");
         }

         $user = $this->findById($userID);

        return new RegisterResponseDto($user['id'], $user['name'], $user['email']);

     }


}