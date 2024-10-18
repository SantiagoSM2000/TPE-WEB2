<?php

    function sesssionAuthMiddleware($response) {
        session_start();
        if (isset($_SESSION["ID_USER"])){
            $response->id = $_SESSION["ID_USER"];
            $response->username = $_SESSION["USERNAME_USER"];
            return;
        }
    }
?>