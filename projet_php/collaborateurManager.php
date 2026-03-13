<?php
require_once 'Collaborateur.php';

class CollaborateurManager{
    private $db;

    public function __construct($database){
        $this->db = $database;
    }

    public function getAll(): array{
        $query = $this->db->query('SELECT * FROM collaborateurs ORDER BY id DESC');

        $collaborateurs = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collaborateurs[] = new Collaborateur(
                $row['nom'],
                (int) $row['age'],
                $row['role'],
                (int) $row['id']
            );
        }

        return $collaborateurs;
    }

    public function add(Collaborateur $collab){
        $req = $this->db->prepare("INSERT INTO collaborateurs (nom, age, role) VALUES (?, ?, ?)");
        $req->execute([$collab->getNom(), $collab->getAge(), $collab->getRole()]);
    }

    public function delete($id){
        $req = $this->db->prepare("DELETE FROM collaborateurs WHERE id = ?");
        $req->execute([$id]);
    }

    public function search($motCle){
        $req = $this->db->prepare("SELECT * FROM collaborateurs WHERE nom LIKE ? OR role LIKE ?");
        $term = "%$motCle%";
        $req->execute([$term, $term]);

        $collaborateurs = [];
        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collaborateurs[] = new Collaborateur(
                $row['nom'],
                (int) $row['age'],
                $row['role'],
                (int) $row['id']
            );
        }

        return $collaborateurs;
    }
}