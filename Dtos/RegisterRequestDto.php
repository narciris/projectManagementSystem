<?php


class RegisterRequestDto
{
    private $email;

    private $password;
    private $name;


    function __construct($email, $password, $name){
        $this->email = $email;
        $this->name = $name;
        $this->password = password_hash($password, PASSWORD_DEFAULT); ;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return [
            'password' => $this->password,
            'name' => $this->name,
            'email' => $this->email
        ];
    }

}