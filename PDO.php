<?php
// ============================================================
// models/Collaborateur.php — Entité Collaborateur
// ============================================================

class Collaborateur
{
    // ── Propriétés privées ────────────────────────────────
    private ?int   $id;
    private string $nom;
    private int    $age;
    private string $role;

    // ── Constructeur ──────────────────────────────────────
    public function __construct(string $nom, int $age, string $role, ?int $id = null)
    {
        $this->id   = $id;
        $this->nom  = $nom;
        $this->age  = $age;
        $this->role = $role;
    }

    // ── Getters ───────────────────────────────────────────
    public function getId(): ?int    { return $this->id;   }
    public function getNom(): string { return $this->nom;  }
    public function getAge(): int    { return $this->age;  }
    public function getRole(): string{ return $this->role; }

    // ── Setters ───────────────────────────────────────────
    public function setId(int $id): void       { $this->id   = $id;   }
    public function setNom(string $nom): void  { $this->nom  = $nom;  }
    public function setAge(int $age): void     { $this->age  = $age;  }
    public function setRole(string $role): void{ $this->role = $role; }
}