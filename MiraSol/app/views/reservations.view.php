<?php

class ReservationsView{
    
    private $user = null;

    public function __construct($user = null) {
        $this->user = $user;
    }
    
    public function displayError($error){//Función para mostrar un error
      require "templates/error.phtml";
    }
    
    public function displayReservations($reservations){//Función que muestra un listado de todas las reservas presentes en la base de datos
        
        require "templates/reservations_list.phtml";
    }
    
    public function displayReservationById($reservation, $client){//Función que muestra más información sobre la reserva especificada
        require "templates/reservation.phtml";
    }
    
    public function displayAddReservation($clients){//Función que muestra un formulario para agregar reserva
        require "templates/form_add_Reservation.phtml";
    }
    
    public function displayEdit($reservation, $client, $clients){//Función que muestra un formulario para editar una reserva
        require "templates/form_edit_Reservation.phtml";
    }
}
