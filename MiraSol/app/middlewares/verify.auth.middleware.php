<?php

    function verifyAuthMiddleware($response) {
        if ($response->username) {
            return;
        } else {
            header("Location: " . BASE_URL . "login");
            //Se evita que siga la ejecución como medida de seguridad
            die();
        }
    }
?>