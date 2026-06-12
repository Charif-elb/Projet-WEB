<?php
session_start();
require_once 'conf/database.php';
require_once 'models/user.php';
require_once 'controllers/usercontroller.php';

$action = $_GET['action'] ?? 'home';
$userController = new UserController();

// --- ACTUALITÉS À LA UNE ---
// Ces données seront bientôt remplacées par une requête SQL vers ta table "posts"
$actualites = [
    [
        'titre' => 'Le nouveau visage du Real Madrid',
        'resume' => 'Kylian Mbappé a officiellement rejoint les rangs madrilènes. Une arrivée qui marque un tournant historique pour la Liga.',
        'image' => 'images/mbappe.avif',
        'lien' => 'index.php?action=actu'
    ],
    [
        'titre' => 'Lamine Yamal : Le joyau du Barça',
        'resume' => 'Le prodige barcelonais continue d\'impressionner le monde du football et devient le pilier central de l\'attaque catalane.',
        'image' => 'images/yamal.webp',
        'lien' => 'index.php?action=actu'
    ]
];

ob_start();

switch ($action) {
    case 'login':
        $userController->login();
        break;
        
    case 'logout':
        $userController->logout();
        break;

    case 'actu':
        echo '<h2 style="margin-bottom: 30px;">Toute l\'actualité</h2>';
        echo '<p>Liste complète des articles...</p>';
        break;

    case 'classement':
        echo '<h2 style="margin-bottom: 30px;">Classement La Liga</h2>';
        echo '<p>Le tableau des scores arrive prochainement.</p>';
        break;

    default:
        // --- SECTION À LA UNE (Grille avec Images) ---
        echo '<h2 style="margin-bottom: 25px; border-left: 5px solid #e60000; padding-left: 15px;">À la une</h2>';
        echo '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">';
        
        foreach ($actualites as $actu) {
            echo '<div style="background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">';
            
            // Affichage de l'image
            echo '  <img src="' . $actu['image'] . '" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Image actu">';

            echo '  <div style="padding: 20px;">';
            echo '      <h3 style="margin-top: 0; font-size: 18px; color: #1a1a1a;">' . $actu['titre'] . '</h3>';
            echo '      <p style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">' . $actu['resume'] . '</p>';
            echo '      <a href="' . $actu['lien'] . '" style="color: #e60000; font-weight: 700; text-decoration: none; font-size: 14px;">Lire la suite →</a>';
            echo '  </div>';
            echo '</div>';
        }
        
        echo '</div>';
        break;
}

$content = ob_get_clean();

// Inclusion du layout général
include 'views/layout.php';
?>