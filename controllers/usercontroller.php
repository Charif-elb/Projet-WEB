<?php
require_once __DIR__ . '/../models/user.php';

class UserController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = User::findByUsername($username);

            // Vérification (utilise === pour le texte brut ou password_verify pour du hash)
            if ($user && ($password === $user['password'])) {
                $_SESSION['username'] = $user['username'];
            }
            // Redirection vers l'accueil quoi qu'il arrive
            header('Location: index.php');
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
?>