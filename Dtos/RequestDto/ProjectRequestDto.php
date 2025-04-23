<?php

class ProjectRequestDto
{
    public string $name;
    public string $description;
    public  string $startDate;
    public  string $deliveryDate;
    public ?string $filePath;
    public function __construct(
        string $name,
        string $description,
        string $startDate,
        string $deliveryDate,
        ? string $filePath)
    {
        $this->name = $name;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->deliveryDate = $deliveryDate;
        $this->filePath = $filePath;

    }

}