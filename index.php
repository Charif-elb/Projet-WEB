<?php
// 1. On garde l'affichage des erreurs activé
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Définir le fuseau horaire sur Paris pour la date et l'heure actuelles
date_default_timezone_set('Europe/Paris');

// 3. Sécurité pour la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conf/database.php';
require_once 'models/user.php';
require_once 'controllers/usercontroller.php';

$action = $_GET['action'] ?? 'home';
$userController = new UserController();

// --- BARRIÈRE DE SÉCURITÉ ---
$pages_interdites = ['actu', 'classement'];

if (in_array($action, $pages_interdites) && !isset($_SESSION['user_id'])) {
    echo "<script>alert('Accès refusé ! Vous devez être connecté pour voir les actualités et le classement.'); window.location.href='index.php';</script>";
    exit();
}
// -----------------------------

// --- BASE DE DONNÉES DES ACTUALITÉS ---
$actualites = [
    1 => [
        'titre' => 'Le cauchemar de Mbappé au Real Madrid',
        'resume' => 'Rien ne va plus pour l\'attaquant français. Entre prestations fantomatiques et tactique stérile, Kylian Mbappé enchaîne une nouvelle saison blanche historique qui tourne au fiasco total chez les Merengues.',
        'image' => 'images/mbappe.avif',
        'contenu_complet' => '
            <p>L\'atterrissage de Kylian Mbappé au Real Madrid vire au drame absolu. Annoncé comme le nouveau Galactique qui devait tout rafler, l\'attaquant français vient de clore une saison 2025-2026 traumatisante, marquée par un <strong>zéro pointé en termes de trophées collectifs</strong>.</p>
            <p>Pourtant, d\'un point de vue purement statistique, les chiffres ne mentent pas : plus de 40 buts inscrits toutes compétitions confondues. Mais l\'arbre ne cache plus la forêt. L\'élimination humiliante en Coupe du Roi face au modeste club d\'Albacete et la sortie précoce en Ligue des Champions ont rendu ses efforts vains. Pire encore, le vestiaire madrilène s\'est fracturé suite aux tensions publiques concernant son positionnement tactique sous la direction de l\'entraîneur intérimaire Álvaro Arbeloa. Alors que son grand rival, le FC Barcelone, célèbre son sacre en LALIGA et que le PSG continue de briller sur la scène européenne, Mbappé est désormais pointé du doigt par le public du Santiago-Bernabéu.</p>'
    ],
    2 => [
        'titre' => 'Lamine Yamal : Le joyau du Barça',
        'resume' => 'Le prodige barcelonais continue d\'impressionner le monde du football et devient le pilier central de l\'attaque catalane.',
        'image' => 'images/yamal.webp',
        'contenu_complet' => '
            <p>À seulement 18 ans, Lamine Yamal s\'est imposé comme le maître à jouer absolu du FC Barcelone, menant le club catalan vers les sommets du football espagnol. Deuxième au classement "The Best" de la FIFA, le jeune ailier affole tous les compteurs de précocité.</p>
            <p>Cependant, tout n\'est pas rose pour le prodige. Victime d\'une <strong>lésion aux ischio-jambiers</strong> lors d\'un match contre le Celta Vigo, Yamal a manqué toute la fin de saison avec le Barça. Alors que le staff médical de Barcelone pousse pour une prudence maximale afin d\'éviter la rechute, la sélection espagnole et Luis de la Fuente font le forcing pour l\'aligner coûte que coûte. Malgré le risque immense d\'aggraver sa blessure, le sélectionneur de la Roja a confirmé qu\'il comptait sur son joyau pour le Mondial.</p>'
    ]
];

ob_start();

switch ($action) {
    case 'register':
        $userController->register();
        break;

    case 'login':
        $userController->login();
        break;
        
    case 'logout':
        $userController->logout();
        break;

    case 'actu':
        $id_article = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // 1. Si un ID est passé, on affiche UN article précis
        if ($id_article > 0 && array_key_exists($id_article, $actualites)) {
            $article = $actualites[$id_article];
            $date_post = date('d/m/Y à H:i');
            $auteur_affichage = (isset($_SESSION['user_pseudo']) && $_SESSION['user_pseudo'] === 'charif') ? 'Moi' : 'charif';

            echo '<div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">';
            echo '  <a href="index.php?action=actu" style="color: #e60000; text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px;">← Retour à la liste</a>';
            echo '  <h2 style="margin-top: 0; font-size: 28px; color: #1a1a1a; margin-bottom: 20px;">' . $article['titre'] . '</h2>';
            echo '  <img src="' . $article['image'] . '" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 6px; margin-bottom: 5px;" alt="Image">';
            // Méta donnée ajoutée ici aussi
            echo '  <div style="padding: 10px 0; font-size: 13px; color: #888; margin-bottom: 20px; border-bottom: 1px solid #eee;">Posté par <strong>' . $auteur_affichage . '</strong> le ' . $date_post . '</div>';
            echo '  <div style="font-size: 16px; line-height: 1.8; color: #333;">' . $article['contenu_complet'] . '</div>';
            echo '</div>';
        } 
        // 2. Sinon, on affiche TOUS les articles en entier
        else {
            echo '<h2 style="margin-bottom: 40px; text-align: center;">Toutes les actualités</h2>';
            echo '<div style="max-width: 800px; margin: 0 auto;">';
            
            $date_post = date('d/m/Y à H:i'); 
            
            foreach ($actualites as $id => $article) {
                $auteur_affichage = (isset($_SESSION['user_pseudo']) && $_SESSION['user_pseudo'] === 'charif') ? 'Moi' : 'charif';

                echo '<div style="margin-bottom: 60px; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eee;">';
                echo '  <h2 style="margin-top: 0; font-size: 28px; color: #1a1a1a; margin-bottom: 20px;">' . $article['titre'] . '</h2>';
                echo '  <img src="' . $article['image'] . '" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 6px; margin-bottom: 5px;" alt="Image">';
                
                // --- LIGNE AJOUTÉE ICI ---
                echo '  <div style="padding: 10px 0; font-size: 13px; color: #888; margin-bottom: 20px; border-bottom: 1px solid #eee;">';
                echo '      Posté par <strong>' . $auteur_affichage . '</strong> le ' . $date_post;
                echo '  </div>';
                
                echo '  <div style="font-size: 16px; line-height: 1.8; color: #333;">' . $article['contenu_complet'] . '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        break;

    case 'classement':
        echo '<h2 style="margin-bottom: 30px;">Classement LALIGA</h2>';
        echo '<p>Le tableau des scores arrive prochainement.</p>';
        break;

    default:
        // --- PAGE D'ACCUEIL ---
        echo '<div style="text-align: center; margin-bottom: 50px; padding: 40px; background: #1a1a1a; color: #fff; border-radius: 8px;">';
        echo '  <h1 style="margin: 0 0 10px 0;">Bienvenue sur Score 67</h1>';
        echo '  <p style="font-size: 18px; color: #ccc;">L\'actualité brûlante de LALIGA, analysée et décryptée en temps réel.</p>';
        echo '</div>';

        echo '<h2 style="margin-bottom: 25px; border-left: 5px solid #e60000; padding-left: 15px;">À la une</h2>';
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 400px)); gap: 30px; justify-content: center; align-items: stretch;">';
        
        $date_post = date('d/m/Y à H:i'); 
        
        foreach ($actualites as $id => $actu) {
            $auteur_affichage = (isset($_SESSION['user_pseudo']) && $_SESSION['user_pseudo'] === 'charif') ? 'Moi' : 'charif';
            
            echo '<div style="background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; height: 100%;">';
            echo '  <img src="' . $actu['image'] . '" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Image actu">';
            
            echo '  <div style="padding: 10px 20px; font-size: 12px; color: #888; background: #f9f9f9; border-bottom: 1px solid #eee;">';
            echo '      Posté par <strong>' . $auteur_affichage . '</strong> le ' . $date_post;
            echo '  </div>';
            
            echo '  <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">';
            echo '      <h3 style="margin-top: 0; font-size: 18px; color: #1a1a1a;">' . $actu['titre'] . '</h3>';
            echo '      <p style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 0; flex-grow: 1;">' . $actu['resume'] . '</p>';
            echo '      <a href="index.php?action=actu&id=' . $id . '" style="color: #e60000; font-weight: 700; text-decoration: none; font-size: 14px; margin-top: 20px; display: block;">Lire la suite →</a>';
            echo '  </div>';
            echo '</div>';
        }
        echo '</div>';

        echo '<div style="margin-top: 60px; padding: 30px; border-top: 2px solid #eee; text-align: center;">';
        echo '  <h3 style="color: #333;">Pourquoi nous suivre ?</h3>';
        echo '  <p style="color: #666; max-width: 600px; margin: 0 auto;">Score 67 est la référence pour les amoureux du football espagnol. Profitez d\'analyses exclusives et du suivi de notre classement du championnat espagnol LALIGA en direct.</p>';
        echo '</div>';

        // --- BOUTON FLOTTANT PUBLIER ---
        echo '<a href="index.php?action=publier" style="position: fixed; bottom: 30px; right: 30px; background-color: #28a745; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.3); display: flex; align-items: center; z-index: 1000;">';
        echo '  <span style="margin-right: 8px; font-size: 20px;">+</span> Publier';
        echo '</a>';
        
        break;
}

$content = ob_get_clean();

include __DIR__ . '/views/layout.php';
?>