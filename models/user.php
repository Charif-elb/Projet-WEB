<?php
// On s'assure que la classe Database est chargée
require_once __DIR__ . '/../conf/database.php';

class User {
    public $id;
    public $username;
    public $password;

    /**
     * Recherche un utilisateur par son nom d'utilisateur
     */
    public static function findByUsername($username) {
        // Utilisation de la classe Database définie dans conf/database.php
        $db = Database::getConnection();
        
        // Préparation de la requête pour éviter les injections SQL
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        
        // On récupère le résultat
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user;
    }

    /**
     * Vérifie si le mot de passe est correct
     */
    public static function checkLogin($username, $password) {
        $user = self::findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
?>