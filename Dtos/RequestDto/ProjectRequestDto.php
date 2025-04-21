<?php

class ProjectRequestDto
{
    public string $name;
    public string $description;
    public  string $startDate;
    public  string $deliveryDate;
    public int $user_id;
    public ?string $filePath;
    public function __construct(string $name, string $description, string $startDate, string $deliveryDate, int $user_id,string $filePath)
    {
        $this->name = $name;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->deliveryDate = $deliveryDate;
        $this->user_id = $user_id;
        $this->filePath = $filePath;

    }

}