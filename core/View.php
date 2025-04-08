<?php

class View {
    public static function head($title, $css) {
        require 'views/layouts/head.php';
    }

    public static function layout($filename) {
        require 'content/layouts/' . $filename . '.php';
    }

    public static function content($filename) {
        require 'content/pages/' . $filename . '.php';
    }
}