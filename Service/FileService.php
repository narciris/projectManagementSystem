<?php

class FileService
{
    public function uploadFile($file,string $directory)
    {
        if (!isset($file['name']) || !isset($file['tmp_name'])) {
            throw new Exception("Archivo inválido", 400);
        }

        $fileName = time() . '_' . basename($file['name']);
        $filePath = $directory . '/' . $fileName;

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $filePath;
        }

        throw new Exception("Error al subir el archivo", 500);


    }

}