<?php

require_once 'core/Security.php';
require_once 'core/View.php';

class Page {
    public function home() {
        Security::checkSession();
        View::head('Home - APG', ["vars","style"]);
        View::layout('header');
        View::content('home');
        View::layout('footer');
    }

    public function chat() {
        Security::checkSession();
        View::head('Chat - APG', ["vars","style"]);
        View::layout('header');
        View::content('home');
        View::layout('footer');
    }
}

?>