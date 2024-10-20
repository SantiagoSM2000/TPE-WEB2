<?php

require_once "Model.php";

class ReservasModel extends Model{

    public function __construct(){//Constructor de la clase
        parent::__construct();//Se invoca al constructor de la clase padre (Model)
    }

    public function getReservations(){

        //Solicito las reservas de la base de datos
        $query = $this->db->prepare("SELECT * FROM reservations");
        $query->execute();
        $reservations = $query->fetchAll(PDO::FETCH_OBJ);
    
        //Devuelvo el arreglo con las reservas
        return $reservations;
    }

    public function getReservationById($id){

        //Solicito la reserva que coincida en la base de datos con el id que me pasaron (NO VERIFICO QUE EL ID EXISTA)
        $query = $this->db->prepare("SELECT * FROM reservations WHERE ID_Reservation = ?");
        $query->execute([$id]);
        $reservation = $query->fetch(PDO::FETCH_OBJ);
    
        //Devuelvo la reserva con el ID solicitado
        return $reservation;
    }

    public function deleteReservation($id){

        //Elimino la reserva que coincida en la base de datos con el id que me pasaron
        $query = $this->db->prepare("DELETE FROM reservations  WHERE ID_Reservation = ?");
        $query->execute([$id]);
    }

    public function insertReservation($date, $room_number, $Image, $ID_Client){
        //Inserto la reserva con los datos del usuario 

        $id = NULL;
        $query = $this->db->prepare("INSERT INTO reservations (ID_Reservation, Date, Room_number, Image, ID_Client) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$id, $date, $room_number, $Image, $ID_Client]);
    
        return $this->db->lastinsertId();
    }

    public function existsReservation($id){
        //Busco la reserva que coincida con el id y si existe retorno true
        $query = $this->db->prepare("SELECT * FROM reservations WHERE ID_Reservation = ?");
        $query->execute([$id]);
        $client = $query->fetch(PDO::FETCH_OBJ);
    
        if($client){
            return true;
        } 
        return false;
    }

    public function updateReservation($id, $date, $room_number, $image, $ID_Client){
        //Inserto la reserva con los datos del usuario 
        $query = $this->db->prepare("UPDATE reservations SET Date=?, Room_number=?, Image=?, ID_Client=? WHERE ID_Reservation=?");
        $query->execute([$date, $room_number, $image, $ID_Client, $id]);
    }
}
