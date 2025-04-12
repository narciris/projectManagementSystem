<?php

namespace core;

class Model
{
    /** @var PDO db **/
    protected $db;
    public function __construct()
    {
        $this->db = Connexion::getConnexion();
    }
}