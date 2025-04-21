<?php

 abstract class Model
{
    /** @var PDO db **/

    /** Encapsulamiento solo las clases hijas pueden acceder a estas propiedaes o atributos**/
    protected $db;
    protected $model;
    public function __construct()
    {
        $this->db = Connexion::getConnexion();
    }


    public function findAll()
    {

        try{
            $stmt = $this->db->query("SELECT * FROM {$this->model}");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (PDOException $e){

            return $e->getMessage();
        }

    }

     public function findById($id)
     {
         try {
             $stmt = $this->db->prepare("SELECT * FROM {$this->model} WHERE id = :id");
             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             $stmt->execute();

             $user = $stmt->fetch(PDO::FETCH_ASSOC);
             if (!$user) {
                 throw new Exception("Usuario con ID {$id} no encontrado", 404);
             }
             return $user;

         } catch (PDOException $e) {
             throw new Exception("Error de base de datos: " . $e->getMessage(), 500);
         } catch (Exception $e){
             throw $e;
         } catch (RuntimeException $e){
             throw new Exception("error en el tismpo de ejecucion",$e->getMessage(), $e->getCode());
         }
     }


     public function save($data)
    {
        try {
          $columns = '';
          $placeholders = '';
          $values = [];

//            var_dump($data);

          foreach ( $data as $key => $value ) {
              $columns .= "$key, ";
              $placeholders .= ":$key, ";
              $values[":$key"] = $value;

          }

            $columns = rtrim($columns, ', ');
            $placeholders = rtrim($placeholders, ', ');

            $sql = "INSERT INTO {$this->model} ({$columns}) VALUES ({$placeholders})";
//            var_dump($sql);

            $stmt = $this->db->prepare($sql);

            foreach ($values as $key => $value){
                $stmt->bindValue("$key", $value);
            }
          $stmt->execute();

            return $this->db->lastInsertId();



        }catch (PDOException $e){
//            var_dump($e->getMessage());
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            if(empty($id)){
                throw new Exception("el id no puede estar vacio");
            }
            $sql = "DELETE FROM {$this->model} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
             $result = $stmt->execute();
            $rowCount = $stmt->rowCount();
            if(  $result &&$rowCount> 0){
                return true;
            } else if ($result){
                return false;
            } else{
                throw new PDOException("error al eliminar registro");
            }
        }catch (PDOException $e){
            error_log("error en el metodo delete", $e->getCode());
            throw $e;
        }catch (InvalidArgumentException $e){
            error_log("argumento invaliden metodo delete", $e->getMessage());
            throw $e;
        }
    }
    public function findByOne($one, $value)
    {

        try{
            $one = preg_replace('/[^a-zA-Z0-9_]/', '', $one);

            $sql = "SELECT * FROM {$this->model} WHERE $one = :$one";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":$one",$value);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }


    }

    public function update($data, $id)
    {
        try {
            $fields = '';
            $values = [];

            foreach ($data as $key => $value){
                $fields .= "$key = :$key, ";
                $values["$key"] = $value;
            }

            $fields = rtrim($fields, ', ');

            $sql = "UPDATE {$this->model} SET $fields WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            foreach ($values as $key => $value){
                $stmt->bindValue("$key", $value);
            }

            $stmt->bindValue(':id',$id);

            $stmt->execute();
            return "registro actualizado";
        }catch (PDOException $e){

            return $e->getMessage();
        }
    }
}