<?php 

require_once "app/views/client.view.php";
require_once "app/models/clients.model.php";

class ClientController{

    private $view;
    private $model;

    public function __construct(){//Constructor de la clase
        $this->view = new ClientView();
        $this->model= new ClientsModel();
    }

    public function showAddClientForm(){        
        //Llamo a la vista para visualizar formulario de clientes
        $this->view->displayAddClient();
    }

    public function addClient(){
        if (!isset($_POST["firstname"]) || empty($_POST["firstname"])){
            return $this->viewReservas->displayError("Faltó completar el nombre");
        }
        if (!isset($_POST["lastname"]) || empty($_POST["lastname"])){
            return $this->viewReservas->displayError("Faltó completar el apellido");
        }
        if (!isset($_POST["email"]) || empty($_POST["email"])){
            return $this->viewReservas->displayError("Faltó completar el email");
        }
        if (!isset($_POST["phone"]) || empty($_POST["phone"])){
            return $this->viewReservas->displayError("Faltó completar el número de celular");
        }
        

        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = htmlspecialchars($_POST["phone"]);


        $id = $this->model->insertClient($firstname, $lastname, $email, $phone);

        header("Location: " . BASE_URL);
    }
}