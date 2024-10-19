<?php

require_once "config.php";

class UserModel{

    private $db;

    public function __construct(){//constructor de la clase
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER , MYSQL_PASS);
    }

    public function getClientByUserName($username){

        //Solicito el usuario de la base de datos
        $query = $this->db->prepare("SELECT * FROM clientes WHERE NombreUsuario = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo el usuario
        return $user;
    }

    public function insertClient($firstname, $lastname, $email, $username, $password, $phone){

        $id = NULL;
        $query = $this->db->prepare("INSERT INTO clientes (ID_Cliente, Nombre, Apellido, Email, NombreUsuario, Contraseña, Telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $query->execute([$id, $firstname, $lastname, $email, $username, $password, $phone]);
    
        return $this->db->lastinsertId();
    }

    
}