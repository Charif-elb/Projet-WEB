<?php
class Database {
    private static $instance = null;

    public static function getConnexion() {
        if (self::$instance === null) {
            try {
                // On utilise le vrai nom visible sur ton image
                $nom_bdd = 'score_67'; 
                
                // Configuration standard de MAMP
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=" . $nom_bdd . ";charset=utf8", 
                    "root", 
                    "root", 
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (Exception $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>