<?php

class AuthView{

    //Se usa el constructor por defecto

    //Muestra un formulario para hacer login
    public function displayLogin($error = ""){
        require "templates/form_login.phtml";
    }

    //TODO muestra formulario para registrarse
    public function displaySignup(){
        require "templates/form_signup.phtml";
    }
}