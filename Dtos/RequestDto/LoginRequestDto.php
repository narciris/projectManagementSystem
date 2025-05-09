<?php

class LoginRequestDto
{

    public string $email;
    public string $password;


    public function __construct($email, $password)
    {
        $this->email =$email;
        $this->password = $password;

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

}