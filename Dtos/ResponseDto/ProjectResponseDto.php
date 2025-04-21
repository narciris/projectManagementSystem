<?php

class ProjectResponseDto
{
    public $id;
    public $name;
    public $startDate;
    public $description;
    public $deliveryDate;
    public $userId;
    public $filePath;


    public function __construct($id, $name, $startDate, $description,$deliveryDate, $userId,$filePath)
    {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->description = $description;
        $this->deliveryDate = $deliveryDate;
        $this->userId = $userId;
        $this->filePath = $filePath;
    }

    public function toArray()
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'startDate' => $this->startDate,
            'description' => $this->description,
            'deliveryDate' => $this->deliveryDate,
            'userId' => $this->userId,
            'file_path'=>$this->filePath
        ];
    }

}