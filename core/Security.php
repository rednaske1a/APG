<?php

class Security {

    public static function checkSession() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

}