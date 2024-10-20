<?php
require_once "app/views/reservations.view.php";
require_once "app/models/reservations.model.php";
require_once "app/models/clients.model.php";

class ReservationsController{

    private $modelReservation;
    private $view;
    private $modelClients;

    public function __construct($response){//Constructor de la clase
        $this->modelReservation = new ReservasModel();
        $this->view = new ReservasView($response);
        $this->modelClients = new ClientsModel();
    }

    public function showReservations(){

        //Llamo al modelo para obtener las reservas ($reservations)
        $reservations = $this->modelReservation->getReservations();
        
        //llamo a la vista para visualizar las reservas
        $this->view->displayReservations($reservations);
    }

    public function validReservationById($id){

        //llamo al modelo para preguntar si existe un resultado de reserva con ese id
        if (!$this->modelReservation->existsReservation($id)){
            return false;
        }
        return true;
    }

    public function showReservationById($id){

        //Llamo al modelo para pedirle la reserva por id y el cliente que corresponde con esa reserva
        $reservation = $this->modelReservation->getReservationById($id);
        $client = $this->modelClients->getClientByID($reservation->ID_Client);
        //Llamo a la vista para visualizar la reserva especificada junto con el cliente 
        $this->view->displayReservationById($reservation, $client);
    }

    public function showAddReservationForm(){
        //Llamo al modelo para obtener las reservas ($reservations)
        $clients = $this->modelClients->getClients();
        
        //Llamo a la vista para visualizar formulario para añadir mostrando la seleccion de clientes
        $this->view->displayAddReservation($clients);
    }

    public function addReservation(){ 
        
        //TODO validación?
        if (!isset($_POST["ID_Cliente"]) || empty($_POST["ID_Cliente"])){
            return $this->view->displayError("Faltó completar el ID del cliente");
        }
        if (!isset($_POST["room_number"]) || empty($_POST["room_number"])){
            return $this->view->displayError("Faltó completar el número de habitación");
        }
        if (!isset($_POST["date"]) || empty($_POST["date"])){
            return $this->view->displayError("Faltó completar la fecha");
        }
        /* Se tiene que habilitar la opción de no subir imagen
        if (!isset($_POST["image"]) || empty($_POST["image"])){ 
            return $this->view->displayError("Faltó completar el link de la imagen");
        }*/
        
        $date = htmlspecialchars($_POST["date"]);
        $room_number = htmlspecialchars($_POST["room_number"]);
        $image = htmlspecialchars($_POST["image"]);
        $ID_Client = htmlspecialchars($_POST["ID_Cliente"]);
        

        $this->modelReservation->insertReservation($date, $room_number, $image, $ID_Client);

        header("Location: " . BASE_URL);
    } 

    public function removeReservation($id){

        //Llamo al modelo para conseguir la reserva con ese id, si no está entonces devuelve null

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }

        //Llamo al modelo para eliminar la reserva con ese id
        $this->modelReservation->deleteReservation($id);
        header("Location: " . BASE_URL);
    }

    public function showEdit($id){

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        } else {
            //Llamo al modelo para mostrar los datos y así saber qué se está cambiando
            $reservation = $this->modelReservation->getReservationById($id);
            $client = $this->modelClients->getClientByID($reservation->ID_Client);
            $clients = $this->modelClients->getClients();
        }
        $this->view->displayEdit($reservation, $client, $clients);
    }

    public function editReservation($id){

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }
        if (!isset($_POST["ID_Client"]) || empty($_POST["ID_Client"])){
            return $this->view->displayError("Faltó completar el id del cliente.");
        }
        if (!isset($_POST["room_number"]) || empty($_POST["room_number"])){
            return $this->view->displayError("Faltó completar el número de habitación.");
        }
        if (!isset($_POST["date"]) || empty($_POST["date"])){
            return $this->view->displayError("Faltó completar la fecha.");
        }
        /* Se tiene que habilitar la opción de no subir imagen
        if (!isset($_POST["image"]) || empty($_POST["image"])){ 
            return $this->view->displayError("Faltó completar el link de la imagen");
        }*/

        $date = htmlspecialchars($_POST["date"]);
        $room_number = htmlspecialchars($_POST["room_number"]);
        $image = htmlspecialchars($_POST["image"]);
        $ID_Client = htmlspecialchars($_POST["ID_Client"]);
    
        $this->modelReservation->updateReservation($id, $date, $room_number, $image, $ID_Client);
        header("Location: " . BASE_URL);
    }
}