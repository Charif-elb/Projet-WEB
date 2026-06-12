<?php
// Models/article.php

class Article {
    private $id_posts;
    private $title;
    private $subtitle;
    private $content;
    private $publishDate;
    private $image;
    private $caption;
    private $id_user;
    private $authorName; // Propriété virtuelle issue de la jointure SQL

    public function __construct(array $donnees = []) {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function hydrate(array $donnees) {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // GETTERS ET SETTERS
    public function getIdPosts() { return $this->id_posts; }
    public function setId_posts($id) { $this->id_posts = (int)$id; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getSubtitle() { return $this->subtitle; }
    public function setSubtitle($subtitle) { $this->subtitle = $subtitle; }

    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; }

    public function getPublishDate() { return $this->publishDate; }
    public function setPublishDate($date) { $this->publishDate = $date; }

    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; }

    public function getCaption() { return $this->caption; }
    public function setCaption($caption) { $this->caption = $caption; }

    public function getIdUser() { return $this->id_user; }
    public function setId_user($id_user) { $this->id_user = (int)$id_user; }

    public function getAuthorName() { return $this->authorName; }
    public function setAuthorName($name) { $this->authorName = $name; }

    // --- REQUÊTES CRUD ---

    // Récupérer tous les posts (Read)
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT p.*, u.username as authorName 
            FROM posts p 
            LEFT JOIN users u ON p.id_user = u.id_users 
            ORDER BY p.publishDate DESC
        ");
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = new Article($row); // Tableau d'objets Article hydratés
        }
        return $articles;
    }

    // Trouver par ID (Read unique)
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id_posts = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
            return new Article($row);
        }
        return null;
    }

    // Insérer en BDD (Create)
    public function save() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO posts (title, subtitle, content, publishDate, image, caption, id_user) 
            VALUES (:title, :subtitle, :content, NOW(), :image, :caption, :id_user)
        ");
        return $stmt->execute([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'image' => $this->image,
            'caption' => $this->caption,
            'id_user' => $this->id_user
        ]);
    }

    // Mettre à jour (Update)
    public function update() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE posts 
            SET title = :title, subtitle = :subtitle, content = :content, image = :image, caption = :caption 
            WHERE id_posts = :id
        ");
        return $stmt->execute([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'image' => $this->image,
            'caption' => $this->caption,
            'id' => $this->id_posts
        ]);
    }

    // Supprimer (Delete)
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM posts WHERE id_posts = :id");
        return $stmt->execute(['id' => $id]);
    }
}