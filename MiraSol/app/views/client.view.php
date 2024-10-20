<?php

class ClientView{

    private $user = null;

    public function __construct($user = null) {
        $this->user = $user;
    }

    //Se usa el constructor por defecto

    //Muestra un formulario para hacer login
    
    public function displayAddClient(){
        require "templates/form_add_Client.phtml";
    }
}