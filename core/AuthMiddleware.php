<?php

//import

require_once __DIR__ . '/../Service/JwtService.php';
class AuthMiddleware
{
    public static function authenticate()
    {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? '';

        if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return false;
        }

        $token = $matches[1];
        $tokenHandler = new JwtService();
        $payload = $tokenHandler->validate($token);

        if (!$payload) {
            return false;
        }

        return $payload['data'];
    }

    public static function checkRole($dataUser,$roles){
        if(!$dataUser || !$dataUser['role']){
            return false;
        }

        if(is_string(!$roles)){
            $roles = [$roles];
        }
        return in_array($dataUser['role'], $roles);
    }

}