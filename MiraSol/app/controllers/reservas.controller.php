<?php
require_once "app/views/reservas.view.php";
require_once "app/models/reservas.model.php";

class ReservasController{

    private $model;
    private $view;

    public function __construct($response){//constructor de la clase
        $this->model = new ReservasModel();
        $this->view = new ReservasView($response);
    }

    public function showReservations(){

        //llamo al modelo para obtener las reservas ($reservations)
        $reservations = $this->model->getReservations();
        
        //llamo a la vista para visualizar las reservas
        $this->view->displayReservations($reservations);
    }

    public function validReservationById($id){

        //llamo al modelo para preguntar si existe un resultado de reserva con ese id
        if (!$this->model->existsReservation($id)){
            return false;
        }
        return true;
    }
        
    public function showReservationById($id){

    //llamo al modelo para pedirle la reserva por id y el cliente que corresponde con esa reserva
    $reserva = $this->model->getReservationById($id);
    $cliente = $this->model->getClientByID($reserva->ID_Cliente);
    //llamo a la vista para visualizar la reserva especificada junto con el cliente 
    $this->view->displayReservationById($reserva, $cliente);
    }
        
    public function showAddForm(){
        $this->view->displayAdd();
    }


        
    public function addReservation(){ 
        
        //TODO validación?
        if (!isset($_POST["username"]) || empty($_POST["username"])){
            return $this->view->displayError("Faltó completar el nombre de usuario");
        }
        if (!isset($_POST["room_number"]) || empty($_POST["room_number"])){
            return $this->view->displayError("Faltó completar el número de habitación");
        }
        if (!isset($_POST["date"]) || empty($_POST["date"])){
            return $this->view->displayError("Faltó completar la fecha");
        }
                
        $username = htmlspecialchars($_POST["username"]);
        $room_number = htmlspecialchars($_POST["room_number"]);
        $date = htmlspecialchars($_POST["date"]);

        $id = $this->model->insertReservation($date, $room_number, $username);

        header("Location: " . BASE_URL);
    } 
        
    public function removeReservation($id){

        //llamo al modelo para conseguir la reserva con ese id, si no está entonces devuelve null

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }

        //llamo al modelo para eliminar la reserva con ese id
        $this->model->deleteReservation($id);
        header("Location: " . BASE_URL);
        }
        

    public function showEdit($id){

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        } else {
            //llamo al modelo para mostrar los datos y así saber qué se está cambiando
            $reserva = $this->model->getReservationById($id);
            $cliente = $this->model->getClientByID($reserva->ID_Cliente);
        }
        $this->view->displayEdit($reserva, $cliente);
    }

    public function editReservation($id){

        if (!$this->validReservationById($id)){
            return $this->view->displayError("No existe la reserva con el ID: " . $id);
        }
        if (!isset($_POST["room_number"]) || empty($_POST["room_number"])){
            return $this->view->displayError("Faltó completar el número de habitación.");
        }
        if (!isset($_POST["date"]) || empty($_POST["date"])){
            return $this->view->displayError("Faltó completar la fecha.");
        }

        $room_number = htmlspecialchars($_POST["room_number"]);
        $date = htmlspecialchars($_POST["date"]);
    
        $this->model->updateReservation($id, $room_number, $date);
        header("Location: " . BASE_URL);
    }





        

}