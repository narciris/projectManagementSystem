<?php

class HomeController extends Controller
{

    public function index(){
        $response = [
            "status" => "success", // Estado general de la respuesta (puede ser success o error)
            "message" => "Bienvenido a la API. Aquí puedes interactuar con los siguientes recursos.",
            "data" => [ // La sección de datos donde puedes poner recursos o información extra
                "available_endpoints" => [
                    [
                        "endpoint" => "/users",
                        "method" => "GET",
                        "description" => "Obtener todos los usuarios"
                    ],
                    [
                        "endpoint" => "/users/{id}",
                        "method" => "GET",
                        "description" => "Obtener usuario por ID"
                    ],
                    [
                        "endpoint" => "/users",
                        "method" => "POST",
                        "description" => "Crear un nuevo usuario"
                    ],
                    [
                        "endpoint" => "/users/{id}",
                        "method" => "PUT",
                        "description" => "Actualizar un usuario"
                    ],
                    [
                        "endpoint" => "/users/{id}",
                        "method" => "DELETE",
                        "description" => "Eliminar un usuario"
                    ]
                ]
            ]
        ];

        $this->jsonResponse($response);
    }

}