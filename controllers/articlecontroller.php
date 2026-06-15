<?php
// Controllers/articlecontroller.php

// On inclut les modèles directement depuis la racine (plus de ../)
require_once 'models/article.php';
require_once 'conf/database.php'; // AJOUT : Connexion à ta base de données score_67

class articlecontroller {

    public function index() {
        // Logique pour afficher les articles
        $articles = article::getAll(); 
        include 'Views/actualites.php';
    }

    public function classement() {
        // Logique pour le classement
        include 'Views/classement.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Logique de création
        }
        include 'Views/add_article.php';
    }

    public function edit($id) {
        $article = article::find($id);
        include 'Views/edit_article.php';
    }

    public function delete($id) {
        article::delete($id);
        header('Location: index.php?action=actualites');
        exit();
    }

    // =========================================================================
    // AJOUT : Fonctions nécessaires pour l'espace commentaires (id_post, id_user, content)
    // =========================================================================

    public function addComment() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        // Sécurité : l'utilisateur doit être connecté pour pouvoir publier
        if (!isset($_SESSION['id_user'])) { 
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_post = intval($_POST['id_post']);
            $id_user = $_SESSION['id_user'];
            $content = trim($_POST['content']);

            if (!empty($id_post) && !empty($content)) {
                $db = Database::getConnexion();
                // Utilisation stricte de tes colonnes de BDD : id_post, id_user, content
                $query = $db->prepare("INSERT INTO comments (id_post, id_user, content) VALUES (?, ?, ?)");
                $query->execute([$id_post, $id_user, $content]);
            }
        }
        
        header("Location: index.php?action=actualites");
        exit();
    }

    public static function getCommentsByPost($id_post) {
        $db = Database::getConnexion();
        
        // Jointure SQL pour lier les commentaires aux comptes utilisateurs (récupération pseudo + pp)
        $query = $db->prepare("
            SELECT c.*, u.pseudo, u.profile_pic 
            FROM comments c 
            JOIN users u ON c.id_user = u.id_user 
            WHERE c.id_post = ?
            ORDER BY c.id_comments DESC
        ");
        $query->execute([$id_post]);
        return $query->fetchAll();
    }
}
?>