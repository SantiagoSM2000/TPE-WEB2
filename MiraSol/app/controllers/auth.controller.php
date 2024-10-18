<?php
require_once "app/views/auth.view.php";
require_once "app/models/user.model.php";

class AuthController{

    private $model;
    private $view;

    public function __construct(){//constructor de la clase
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin(){

        //llamo a la vista para mostrar el formulario
        $this->view->displayLogin();
    }

    public function login(){ 
        
        
        //Valida el nombre de usuario
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->view->displayLogin("Faltó completar el nombre de usuario");
        }

        //Valida la contraseña
        if (!isset($_POST["password"]) || empty($_POST["password"])){
            return $this->view->displayLogin("Faltó completar la contraseña");
        }
                
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        //Verificar que el usuario está en la base de datos

        $userFromDB = $this->model->getUserByUserName($username);
                

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
        password_hash($password, PASSWORD_BCRYPT);
    }

    public function signup(){

    }

}