<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnexion(); 
    }

    // On cherche maintenant dans la colonne 'username'
    public function findByPseudo($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // On insère dans la colonne 'username'
    public function create($username, $hashedPassword) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }
}
?>