<?php

class Project extends Model
{
    protected $model = 'projects';


    public function findAllByUserId($userId)
    {
        try {
            $query = "SELECT * FROM projects WHERE user_id=:user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id',$userId );
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (PDOException $e) {
            throw  new PDOException("erro al realizar operacion",
                $e->getCode(),
                $e->getMessage());
        }

    }



}