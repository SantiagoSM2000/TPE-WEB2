<?php
require_once "app/views/auth.view.php";
require_once "app/models/user.model.php";
require_once "app/views/reservas.view.php";

class AuthController{

    private $model;
    private $view;
    private $viewReservas;

    public function __construct(){//constructor de la clase
        $this->model = new UserModel();
        $this->view = new AuthView();
        $this->viewReservas = new ReservasView();
    }

    public function showLogin(){

        //llamo a la vista para mostrar el formulario
        $this->view->displayLogin();
    }

    public function login(){ 
        
        
        //Valida el nombre de usuario
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->viewReservas->displayLogin("Faltó completar el nombre de usuario");
        }

        //Valida la contraseña
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return $this->viewReservas->displayLogin("Faltó completar la contraseña");
        }
                
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        //Verificar que el usuario está en la base de datos

        $userFromDB = $this->model->getClientByUserName($username);
                

        if ($userFromDB && password_verify($password, $userFromDB->Contraseña)){
            //Guardo en la sesión el ID del usuario
            session_start();

            $_SESSION["ID_USER"] = $userFromDB->ID_Cliente;
            $_SESSION["USERNAME_USER"] = $userFromDB->NombreUsuario;
            $_SESSION["LAST_ACTIVITY"] = time();
            $_SESSION["NAME_USER"] = $userFromDB->Nombre;


            header("Location: " . BASE_URL);

        } else {
            return $this->view->displayLogin("Credenciales incorrectas");
        }

    
        //$id = $this->model->insertUser($username, $password);


    }

    public function logout(){
        session_start(); //Busca la cookie
        session_destroy(); //Destruye la cookie
        header("Location: " . BASE_URL);
    }

    public function showSignup(){
        //llamo a la vista para mostrar el formulario de registro
        $this->view->displaySignup();
        
    }

    public function signup(){
        if (!isset($_POST["firstname"]) || empty($_POST["firstname"])){
            return $this->viewReservas->displayError("Faltó completar el nombre");
        }
        if (!isset($_POST["lastname"]) || empty($_POST["lastname"])){
            return $this->viewReservas->displayError("Faltó completar el apellido");
        }
        if (!isset($_POST["email"]) || empty($_POST["email"])){
            return $this->viewReservas->displayError("Faltó completar el email");
        }
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->viewReservas->displayError("Faltó completar el nombre de usuario");
        }
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return $this->viewReservas->displayError("Faltó completar la contraseña");
        }
        if (!isset($_POST["phone"]) || empty($_POST["phone"])){
            return $this->viewReservas->displayError("Faltó completar el número de celular");
        }
        

        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        $phone = htmlspecialchars($_POST["phone"]);


        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $id = $this->model->insertClient($firstname, $lastname, $email, $username, $hashedPassword, $phone);

        $userFromDB = $this->model->getClientByUserName($username);

        session_start();

        $_SESSION["ID_USER"] = $userFromDB->ID_Cliente;
        $_SESSION["USERNAME_USER"] = $username;
        $_SESSION["LAST_ACTIVITY"] = time();

        header("Location: " . BASE_URL);
    }

}