<?php
require_once "app/libs/response.php";

require_once "app/middlewares/session.auth.middleware.php";
require_once "app/middlewares/verify.auth.middleware.php";

require_once "app/controllers/reservations.controller.php";
require_once "app/controllers/auth.controller.php";
require_once "app/controllers/client.controller.php";


//BASE_URL para redirecciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$response = new Response();

$action = "reservations"; //Accion por defecto
if (!empty($_GET["action"])){
    $action = $_GET["action"];
}



//    TABLA DE RUTEO
//      Action        Funcion
//      reservas      ReservasController->showReservations()
//      reserva/:id   ReservasController->showReservationById($id) P
//      addform       ReservasController->showAddForm() --> add --> ReservasController->addReservation()
//      showedit      ReservasController->showEdit() --> edit --> ReservasController->editReservation()
//      delete/:id    ReservasController->removeReservation($id)
//      showlogin     AuthController->showLogin() --> login --> AuthController->login()
//      logout        AuthController->logout()
//      showsignup     AuthController->showSignup() --> signup --> AuthController->signup()


//Parsea la accion para separar accion de parametros
$params = explode("/",$action);

switch ($params[0]) {
    case "reservations":
        sesssionAuthMiddleware($response);
        $controller = new ReservationsController($response);
        $controller->showReservations();
        break;

    case "reservation":
        sesssionAuthMiddleware($response);
        $controller = new ReservationsController($response);
        if(isset($params[1])){
            $controller->showReservationById($params[1]);
        }else{
            header("Location: " . BASE_URL);
        }
        break;

    case "addReservation":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ReservationsController($response);       
        $controller->showAddReservationForm();
        break;

    case "add":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ReservationsController($response);       
        $controller->addReservation();
        break;

    case "addClient":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ClientController($response);       
        $controller->showAddClientForm();
        break;

    case "addClientToDB":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ClientController($response);       
        $controller->addClient();
        break;

    case "editReservation":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ReservationsController($response);
        if(isset($params[1])){
            $controller->showEdit($params[1]);
        }else{
            header("Location: " . BASE_URL);
        }
        break;

    case "edit":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ReservationsController($response);     
        $controller->editReservation($params[1]);
        break;

    case "delete":
        sesssionAuthMiddleware($response);
        verifyAuthMiddleware($response);//Verifica que el usuario esté logueado
        $controller = new ReservationsController($response);
        if(isset($params[1])){
            $controller->removeReservation($params[1]);
        }else{
            header("Location: " . BASE_URL);
        }
        break;

    case "login":
        $controller = new AuthController();
        $controller->showLogin();
        break;

    case "loginAuth":
        $controller = new AuthController();
        $controller->login();
        break;

    case "logout":
        $controller = new AuthController();
        $controller->logout();
        break;

    case "signup":
        $controller = new AuthController();
        $controller->showsignup();
        break;

    case "signupAuth":
        $controller = new AuthController();
        $controller->signup();
        break;
        
    default:
        echo "Error 404 Page Not Found";
        header("Location: " . BASE_URL);
        break;
}