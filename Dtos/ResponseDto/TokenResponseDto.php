<?php

class TokenResponseDto
{
    public string $token;
    public   $user;


    public function __construct(string $token,   $user)
    {
        $this->token = $token;
        $this->user = $user;
    }


    public function toArray():array
    {
        return [
            'user' =>  $this->user,
            'token' =>  $this->token,
        ];
    }

}