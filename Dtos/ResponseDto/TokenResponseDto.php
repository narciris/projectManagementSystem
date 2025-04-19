<?php

class TokenResponseDto
{
    public string $token;
    public  array $user;


    public function __construct(string $token,  array $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    public function toArray():array
    {
        return [
            'user' =>  $this->user,
            'token' =>  $this->token,
        ];
    }

}