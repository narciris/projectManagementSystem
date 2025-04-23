<?php
//import
require_once  __DIR__ . '/../Dtos/RegisterRequestDto.php';
require_once __DIR__ . '/../Dtos/ResponseDto/UserResponseDto.php';
require_once  __DIR__ . '/../Service/UserServiceImpl.php';
require_once  __DIR__ . '/../core/AuthMiddleware.php';
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
               $this->jsonSuccess($response);
           }

           $this->jsonSuccess($response);

        } catch (Exception $e) {
            $this->jsonError($e->getMessage(), 400);
        }

    }

    public function show(): void
    {
        try {
            $userAuthenticate = AuthMiddleware::authenticate();
            if(!$userAuthenticate)
            {
                throw new Exception("usuario no autenticado");
            }
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





    public function delete($id) {
        try {
            $userAuthenticate = AuthMiddleware::authenticate();
            if(!$userAuthenticate)
            {
                throw new Exception("usuario no autenticado");
            }

            $result = $this->userService->deleteUser($id);

            $this->jsonSuccess([
                'message' => 'Usuario eliminado correctamente',
                'id' => $id
            ]);
        } catch (Exceptions\ResourceNotFoundException $e) {
            $this->jsonError($e->getMessage(), 404);
        } catch (InvalidArgumentException $e) {
            $this->jsonError($e->getMessage(), 400);
        } catch (Exceptions\DataAccessException $e) {
            $this->jsonError('Error al acceder a la base de datos', 500);
            error_log($e->getMessage());
        } catch (Exception $e) {
            $this->jsonError('Error en el servicio', 500);
            error_log($e->getMessage());
        } catch (Exception $e) {
            $this->jsonError('Error interno del servidor', 500);
            error_log("Error inesperado en delete: " . $e->getMessage());
        }
    }

    public function update()
    {

    }


}