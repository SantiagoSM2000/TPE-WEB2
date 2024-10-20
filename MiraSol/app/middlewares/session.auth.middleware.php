<?php

    function sesssionAuthMiddleware($response) {
        session_start();
        if (isset($_SESSION["USERNAME_USER"])){
            $response->username = $_SESSION["USERNAME_USER"];
            return;
        }
    }
?>