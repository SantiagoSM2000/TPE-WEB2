<?php

require_once "Model.php";

class UserModel extends Model{

    public function __construct(){//Constructor de la clase con las constantes del config.php
        parent::__construct();//Se invoca al constructor de la clase padre (Model)
    }

    public function getUserByUserName($username){//Función para conseguir el usuario por nombre de usuario desde la base de datos

        //Solicito el usuario de la base de datos
        $query = $this->db->prepare("SELECT * FROM users WHERE Username = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo el usuario
        return $user;
    }

    public function insertUser($username, $password){

        $id = NULL;
        $query = $this->db->prepare("INSERT INTO users (ID_User, Username, Password) VALUES (?, ?, ?)");
        $query->execute([$id,$username, $password]);
    
        return $this->db->lastinsertId();
    }

    
}