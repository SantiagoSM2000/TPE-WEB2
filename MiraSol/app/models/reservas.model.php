<?php

class ReservasModel{

    private $db;

    public function __construct(){//constructor de la clase
        $this->db = new PDO('mysql:host=localhost;dbname=hoteldb;charset=utf8','root','');
    }

    public function getReservations(){

        //Solicito las reservas de la base de datos
        $query = $this->db->prepare("SELECT * FROM reservas");
        $query->execute();
        $reservations = $query->fetchAll(PDO::FETCH_OBJ);
    
        //Devuelvo el arreglo con las reservas
        return $reservations;
    }

    public function getReservationById($id){

        //Solicito la reserva que coincida en la base de datos con el id que me pasaron (NO VERIFICO QUE EL ID EXISTA)
        $query = $this->db->prepare("SELECT * FROM reservas WHERE ID_Reserva = ?");
        $query->execute([$id]);
        $reservation = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo la reserva con el ID solicitado
        return $reservation;
    }

    public function getClientById($id){

        //Solicito el cliente que coincida en la base de datos con el id que me pasaron 
        $query = $this->db->prepare("SELECT * FROM clientes WHERE ID_Cliente = ?");
        $query->execute([$id]);
        $client = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo el cliente con el ID solicitado
        return $client;
    }

    public function getClientByUsername($username){
        $query = $this->db->prepare("SELECT * FROM clientes WHERE NombreUsuario = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function deleteReservation($id){

        //Elimino la reserva que coincida en la base de datos con el id que me pasaron
        $query = $this->db->prepare("DELETE FROM reservas  WHERE ID_Reserva = ?");
        $query->execute([$id]);
    }

    public function insertReservation($fecha, $nro_Habitacion, $nombre){
        //Inserto la reserva con los datos del usuario 
        
        $user = $this->getClientByUsername($nombre);

        $id = NULL;
        $query = $this->db->prepare("INSERT INTO reservas (ID_Reserva, Fecha, Nro_Habitacion, ID_Cliente) VALUES (?, ?, ?, ?)");
        $query->execute([$id, $fecha, $nro_Habitacion, $user->ID_Cliente]);
    
        return $this->db->lastinsertId();
    }

    public function existsReservation($id){
        //Busco la reserva que coincida con el id y si existe retorno true
        $query = $this->db->prepare("SELECT * FROM reservas WHERE ID_Reserva = ?");
        $query->execute([$id]);
        $client = $query->fetch(PDO::FETCH_OBJ);
    
        if($client){
            return true;
        } 
        return false;
    }

    public function updateReservation($id, $room_number, $date){
        //Inserto la reserva con los datos del usuario 
        $query = $this->db->prepare("UPDATE reservas SET Nro_Habitacion=?, Fecha=? WHERE ID_Reserva=?");
        $query->execute([$room_number, $date, $id]);
    }
}