<?php

class ReservasView{
    
    private $user = null;

    public function __construct($user = null) {
        $this->user = $user;
    }


    //Muestra un error
    public function displayError($error){
      require "templates/error.phtml";
    }

    //Muestra un listado de todas las reservas presentes en la base de datos
    public function displayReservations($reservations){
        
        require "templates/reservations_list.phtml";
    }

    //Muestra más información sobre la reserva especificada
    public function displayReservationById($reservation, $client){ 
        require "templates/reservation.phtml";
    }

    //Muestra un formulario para agregar reserva
    public function displayAddReservation($clients){
        require "templates/form_add_Reservation.phtml";
    }
    
    //Muestra un formulario para editar una reserva
    public function displayEdit($reservation, $client, $clients){
        require "templates/form_edit_Reservation.phtml";
    }
}
