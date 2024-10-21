<?php

class AuthView{

    //Se usa el constructor por defecto

    //Muestra un formulario para hacer login
    public function displayLogin($error = ""){
        require "templates/form_login.phtml";
    }
    
    public function displaySignup(){//Función para mostrar formulario para registrarse
        require "templates/form_signup.phtml";
    }
}