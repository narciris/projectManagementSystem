<?php


require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../Exceptions/DataAccessException.php';
require_once __DIR__ . '/../Exceptions/ResourceNotFoundException.php';
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


  public function deleteUser($id) {
      try {
//          if (!is_numeric($id) || $id <= 0) {
//              throw new InvalidArgumentException("ID de usuario inválido");
//          }

          $result = $this->model->delete($id);

          if (!$result) {
              throw new Exceptions\ResourceNotFoundException("Usuario con ID {$id} no encontrado");
          }

          return true;
      } catch (PDOException $e) {
          error_log("Error de base de datos en deleteUser: " . $e->getMessage());
          throw new Exceptions\DataAccessException("Error al eliminar el usuario: " . $e->getCode(), 500, $e);
      } catch (InvalidArgumentException $e) {
          throw $e;
      } catch (Exceptions\ResourceNotFoundException $e) {
          throw $e;
      } catch (Exception $e) {
          error_log("Error inesperado en deleteUser: " . $e->getMessage());
          throw new Exception("Error interno al procesar la solicitud", 500, $e);
      }
  }


}