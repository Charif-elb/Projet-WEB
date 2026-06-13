<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // --- INSCRIPTION ---
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($pseudo) && !empty($password)) {
                if ($this->userModel->findByPseudo($pseudo)) {
                    echo "<script>alert('Ce pseudo est déjà pris !'); window.location.href='index.php';</script>";
                    exit();
                }

                // Hachage pour les nouveaux inscrits
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($this->userModel->create($pseudo, $hashedPassword)) {
                    echo "<script>alert('Inscription réussie ! Vous pouvez vous connecter.'); window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('Erreur lors de l\'inscription.'); window.location.href='index.php';</script>";
                }
            }
        }
    }

    // --- CONNEXION ---
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($pseudo) && !empty($password)) {
                $user = $this->userModel->findByPseudo($pseudo);

                if (!$user) {
                    echo "<script>alert('Pseudo ou mot de passe incorrect.'); window.location.href='index.php';</script>";
                    exit();
                }

                // DOUBLE VÉRIFICATION : 
                // 1. Soit le mot de passe est crypté (password_verify)
                // 2. Soit il est en texte clair dans la BDD ($password === $user['password'])
                if (password_verify($password, $user['password']) || $password === $user['password']) {
                    
                    // Connexion réussie ! On remplit la session avec tes colonnes
                    $_SESSION['user_id'] = $user['id_users']; 
                    $_SESSION['user_pseudo'] = $user['username']; 
                    
                    // --- AJOUT DE L'ADMIN ---
                    if ($user['username'] === 'charif') {
                        $_SESSION['user_role'] = 'admin';
                    } else {
                        $_SESSION['user_role'] = 'membre';
                    }
                    // ------------------------
                    
                    header('Location: index.php');
                    exit();
                } else {
                    echo "<script>alert('Pseudo ou mot de passe incorrect.'); window.location.href='index.php';</script>";
                }
            }
        }
    }

    // --- DÉCONNEXION ---
    public function logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
        exit();
    }
}