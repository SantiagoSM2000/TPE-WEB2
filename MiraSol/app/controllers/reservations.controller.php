<?php
require_once "app/views/reservations.view.php";
require_once "app/models/reservations.model.php";
require_once "app/models/clients.model.php";

class ReservationsController{

    private $modelReservations;
    private $view;
    private $modelClients;

    public function __construct($response){//Constructor de la clase
        $this->modelReservations = new ReservationsModel();
        $this->view = new ReservationsView($response);
        $this->modelClients = new ClientsModel();
    }

    public function showReservations(){//Función que muestra el listado de reservas

        //Llamo al modelo para obtener las reservas ($reservations)
        $reservations = $this->modelReservations->getReservations();
        
        //Llamo a la vista para visualizar las reservas
        $this->view->displayReservations($reservations);
    }

    public function showReservationById($id){//Función para mostrar una reserva específica por id

        if (!$this->modelReservations->existsReservation($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }
        //Llamo al modelo para pedirle la reserva por id y el cliente que corresponde con esa reserva
        $reservation = $this->modelReservations->getReservationById($id);
        $client = $this->modelClients->getClientByID($reservation->ID_Client);
        //Llamo a la vista para visualizar la reserva especificada junto con el cliente 
        $this->view->displayReservationById($reservation, $client);
    }

    public function showAddReservationForm(){//Función para mostrar el formulario reserva
        //Llamo al modelo para obtener las reservas ($reservations)
        $clients = $this->modelClients->getClients();
        
        //Llamo a la vista para visualizar formulario para añadir mostrando la seleccion de clientes
        $this->view->displayAddReservation($clients);
    }

    public function addReservation(){//Función para recibir los inputs del formulario, validarlos e insertarlos en la base de datos
        
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
        

        $this->modelReservations->insertReservation($date, $room_number, $image, $ID_Client);

        header("Location: " . BASE_URL);
    } 

    public function removeReservation($id){//Función para eliminar una reserva por id

        //Llamo al modelo para conseguir la reserva con ese id, si no está entonces devuelve null

        if (!$this->modelReservations->existsReservation($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }

        //Llamo al modelo para eliminar la reserva con ese id
        $this->modelReservations->deleteReservation($id);
        header("Location: " . BASE_URL);
    }

    public function showEdit($id){//Función para mostrar el formulario de editar

        if (!$this->modelReservations->existsReservation($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        } else {
            //Llamo al modelo para mostrar los datos y así saber qué se está cambiando
            $reservation = $this->modelReservations->getReservationById($id);
            $client = $this->modelClients->getClientByID($reservation->ID_Client);
            $clients = $this->modelClients->getClients();
        }
        $this->view->displayEdit($reservation, $client, $clients);
    }

    public function editReservation($id){//Función para recibir los inputs del formulario, validarlos y actualizar la reserva

        if (!$this->modelReservations->existsReservation($id)){
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
    
        $this->modelReservations->updateReservation($id, $date, $room_number, $image, $ID_Client);
        header("Location: " . BASE_URL);
    }
}