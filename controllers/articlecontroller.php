<?php
// Controllers/articlecontroller.php

// On inclut les modèles directement depuis la racine (plus de ../)
require_once 'models/article.php';

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
}