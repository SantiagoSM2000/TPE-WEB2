<?php 

require_once "Model.php";

class ClientsModel extends Model{

    public function __construct(){//Constructor de la clase con las constantes del config.php
        parent::__construct();//Se invoca al constructor de la clase padre (Model)
    }

    public function getClients(){

        //Solicito las reservas de la base de datos
        $query = $this->db->prepare("SELECT * FROM clients");
        $query->execute();
        $clients = $query->fetchAll(PDO::FETCH_OBJ);
    
        //Devuelvo el arreglo con las reservas
        return $clients;
    }

    public function getClientById($id){

        //Solicito el cliente que coincida en la base de datos con el id que me pasaron 
        $query = $this->db->prepare("SELECT * FROM clients WHERE ID_Client = ?");
        $query->execute([$id]);
        $client = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo el cliente con el ID solicitado
        return $client;
    }

    public function getClientByUsername($username){
        $query = $this->db->prepare("SELECT * FROM clients WHERE NombreUsuario = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function insertClient($Firstname, $Lastname, $Email, $Phone_number){
        $id = NULL;
        $query = $this->db->prepare("INSERT INTO clients (ID_Client, Firstname, Lastname, Email, Phone_number) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$id, $Firstname, $Lastname, $Email, $Phone_number]);
    
        return $this->db->lastinsertId();
    }
}