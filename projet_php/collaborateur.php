<?php
class Collaborateur {
    private $id;
    private $nom;
    private $age;
    private $role;

    public function __construct($nom = null, $age = null, $role = null, $id = null) {
        $this->nom = $nom;
        $this->age = $age;
        $this->role = $role;
        $this->id = $id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getAge() { return $this->age; }
    public function getRole() { return $this->role; }

    // Setters (essentiels pour la modification)
    public function setNom($nom) { $this->nom = $nom; }
    public function setAge($age) { $this->age = $age; }
    public function setRole($role) { $this->role = $role; }
}