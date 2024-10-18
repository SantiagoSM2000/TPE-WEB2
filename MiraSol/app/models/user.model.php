<?php<?php

class UserModel{

    private $db;

    public function __construct(){//constructor de la clase
        $this->db = new PDO('mysql:host=localhost;dbname=hoteldb;charset=utf8','root','');
    }

    public function getUserByUserName($username){

        //Solicito el usuario de la base de datos
        $query = $this->db->prepare("SELECT * FROM clientes WHERE NombreUsuario = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo el usuario
        return $user;
    }

    
}