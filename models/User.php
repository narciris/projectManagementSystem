<?php

require_once __DIR__ . '/../core/Connexion.php';
require_once __DIR__ . '/../core/Model.php';

use core\Model;

class User extends Model
{


    public function findAll()
    {

        try{
            $stmt = $this->db->query('SELECT * FROM users');
            $stmt->execute();
             return $stmt->fetchAll();
        }catch (PDOException $e){

            return $e->getMessage();
        }

    }

    public function findById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParama(':id',$id);
        $stmt->execute();

    }

    public function save($name, $email, $password)
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email,password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name',$name);

    }

}