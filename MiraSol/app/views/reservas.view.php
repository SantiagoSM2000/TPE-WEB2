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
        
        require "templates/lista_reservas.phtml";
    }

    //Muestra más información sobre la reserva especificada
    public function displayReservationById($reserva, $cliente){ 
        require "templates/reserva.phtml";
    }

    //Muestra un formulario para agregar reserva
    public function displayAdd(){
        require "templates/form_add.phtml";
    }
    
    //Muestra un formulario para editar una reserva
    public function displayEdit($reserva, $cliente){
        require "templates/form_edit.phtml";
    }


}
