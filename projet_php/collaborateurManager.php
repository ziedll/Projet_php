<?php
require_once 'Collaborateur.php';

class CollaborateurManager {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM collaborateurs ORDER BY id DESC");
        return $query->fetchAll(PDO::FETCH_CLASS, 'Collaborateur');
    }

    public function add(Collaborateur $collab) {
        $req = $this->db->prepare("INSERT INTO collaborateurs (nom, age, role) VALUES (?, ?, ?)");
        $req->execute([$collab->getNom(), $collab->getAge(), $collab->getRole()]);
    }

    public function delete($id) {
        $req = $this->db->prepare("DELETE FROM collaborateurs WHERE id = ?");
        $req->execute([$id]);
    }

    public function search($motCle) {
        $req = $this->db->prepare("SELECT * FROM collaborateurs WHERE nom ILIKE ? OR role ILIKE ?");
        $term = "%$motCle%";
        $req->execute([$term, $term]);
        return $req->fetchAll(PDO::FETCH_CLASS, 'Collaborateur');
    }
}