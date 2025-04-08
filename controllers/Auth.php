<?php

require_once 'core/View.php';

class Auth {

    public function __construct() {
        $this->pdo = require 'core/db.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->validateUser($username, $password)) {
                session_start();
                $_SESSION['user'] = $username;
                header('Location: /home');
                exit();
            } else {
                echo "Invalid username or password!";
            }
        }

        View::head('Login - APG', ["vars","style"]);
        View::layout('header-login');
        View::content('login');
        View::layout('footer');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if(!$user){
                $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt->execute([$username, $hash]);

                session_start();
                $_SESSION['user'] = $username;
                header('Location: /home');
                exit();
            } else {
                echo "Username already exists!";
            }
        }

        View::head('Register - APG', ["vars","style"]);
        View::layout('header-login');
        View::content('register');
        View::layout('footer');
    }

    private function validateUser($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        return $user && password_verify($password, $user['password']);

    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
