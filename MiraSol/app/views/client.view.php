<?php

class ClientView{

    private $user = null;

    public function __construct($user = null) {
        $this->user = $user;
    }
    
    public function displayAddClient(){//Función para mostrar un formulario para hacer login
        require "templates/form_add_Client.phtml";
    }
}