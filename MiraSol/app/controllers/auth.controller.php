<?php
require_once "app/views/auth.view.php";
require_once "app/models/user.model.php";
require_once "app/views/reservations.view.php";

class AuthController{

    private $model;
    private $view;
    private $viewReservations;

    public function __construct(){//Constructor de la clase

        $this->model = new UserModel();
        $this->view = new AuthView();
        //Se llama al ReservasView para mostrar los errores, se debería de hacer un ErroresView asi se separan las responsabilidades correctamente
        $this->viewReservations = new ReservationsView();
    }

    public function showLogin(){//Función para mostrar el formulario de login

        //Llamo a la vista para mostrar el formulario de inicio de sesión
        $this->view->displayLogin();
    }

    public function login(){ //Función para realizar la comprobación del login e inicio de sesión si las credenciales son correctas
        
        //Valida el nombre de usuario
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->viewReservations->displayLogin("Faltó completar el nombre de usuario");
        }

        //Valida la contraseña
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return $this->viewReservations->displayLogin("Faltó completar la contraseña");
        }
                
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);


        //LLama al modelo para traer al usuario de la base de datos

        $userFromDB = $this->model->getUserByUserName($username);
                
        //Comprobar si la contraseña ingresada corresponde al hash almacenado
        if ($userFromDB && password_verify($password, $userFromDB->Password)){
            //Se inicia la sesión
            session_start();
            //Guardo en la sesión el id del usuario, el nombre de usuario y la ultima actividad (se podría usar para hacer un timeout y cerrar la sesion luego de x tiempo)
            $_SESSION["ID_USER"] = $userFromDB->ID_User;
            $_SESSION["USERNAME_USER"] = $userFromDB->Username;
            $_SESSION["LAST_ACTIVITY"] = time();

            //Con header me dirijo al url base del sitio
            header("Location: " . BASE_URL);
        } else {
            //Llamo a la vista para mostrar el formulario con el mensaje de error 
            return $this->view->displayLogin("Credenciales incorrectas");
        }
    }

    public function logout(){//Función para cerrar sesión
        
        session_start(); //Busca la cookie
        session_destroy(); //Destruye la cookie
        header("Location: " . BASE_URL);
    }

    public function showSignup(){//Función para mostrar el formulario de registro

        //Llamo a la vista para mostrar el formulario de registro
        $this->view->displaySignup();
        
    }

    public function signup(){//Función para realizar la comprobación del signup, almacenar el nuevo usuario y luego iniciar la sesión con esas credenciales

        //Valida el nombre de usuario
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->viewReservations->displayError("Faltó completar el nombre de usuario");
        }

        //Valida la contraseña
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return $this->viewReservations->displayError("Faltó completar la contraseña");
        }
        
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        //LLamo al modelo para conseguir el usuario por nombre de usuario, si me retorna algo distinto a NULL el usuario ya existe
        $userFromDB = $this->model->getUserByUserName($username);

        if ($userFromDB != NULL){
            return $this->viewReservations->displayError("Ya existe un usuario con ese nombre de usuario");
        }

        //Hashea la contraseña ingresada usando bcrypt

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        //Se inserta el usuario nuevo con la contraseña hasheada

        $id = $this->model->insertUser($username, $hashedPassword);

        //Se inicia la sesión
        session_start();
        ////Guardo en la sesión el nombre de usuario y la ultima actividad
        $_SESSION["USERNAME_USER"] = $username;
        $_SESSION["LAST_ACTIVITY"] = time();

        //Con header me dirijo al url base del sitio
        header("Location: " . BASE_URL);
    }

}