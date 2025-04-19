<?php


class UserResponseDto
{
    public $id;
    public $name;
    public $email;


    public function __construct($id, $name, $email){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function toArray() : array
    {
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email
        ];
    }


}