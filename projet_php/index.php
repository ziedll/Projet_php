<?php
require_once 'database.php';
require_once 'CollaborateurManager.php';

$pdo = Database::getInstance();
$manager = new CollaborateurManager($pdo);
$erreur = "";

// LOGIQUE : Ajout d'un membre (POST)
if (isset($_POST['ajouter'])) {
    if (!empty($_POST['nom']) && !empty($_POST['age']) && !empty($_POST['role'])) {
        if ($_POST['age'] >= 18) {
            $nouveau = new Collaborateur($_POST['nom'], (int)$_POST['age'], $_POST['role']);
            $manager->add($nouveau);
            header('Location: index.php');
            exit();
        } else {
            $erreur = "Inscription refusée : l'employé doit être majeur.";
        }
    }
}

// LOGIQUE : Suppression
if (isset($_GET['delete'])) {
    $manager->delete((int)$_GET['delete']);
    header('Location: index.php');
    exit();
}

// LOGIQUE : Recherche (GET) ou Affichage global
$membres = isset($_GET['nom']) && $_GET['nom'] !== '' ? $manager->search($_GET['nom']) : $manager->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <h1>⚡ Nexus Hub</h1>
        <p class="subtitle">Annuaire Interne — Nexus Dynamics</p>

        <!-- BARRE DE RECHERCHE (GET) -->
        <header>
            <form action="index.php" method="GET" class="search-bar">
                <input type="search" name="nom" placeholder="Rechercher par nom ou rôle..."
                       value="<?= htmlspecialchars($_GET['nom'] ?? '') ?>">
                <button type="submit">🔍 Rechercher</button>
                <?php if (!empty($_GET['nom'])): ?>
                    <a href="index.php" class="reset-btn">✕ Réinitialiser</a>
                <?php endif; ?>
            </form>
        </header>

        <!-- MESSAGE D'ERREUR -->
        <?php if ($erreur): ?>
            <p class="error-msg">⚠️ <?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <!-- FORMULAIRE D'AJOUT (POST) -->
        <section>
            <h2>Ajouter un collaborateur</h2>
            <form method="POST" class="add-form">
                <input type="text"   name="nom"  placeholder="Nom complet" required>
                <input type="number" name="age"  placeholder="Âge" min="1" max="99" required>
                <select name="role">
                    <option value="Développeur">Développeur</option>
                    <option value="Designer">Designer</option>
                    <option value="Chef de projet">Chef de projet</option>
                    <option value="Directeur">Directeur</option>
                </select>
                <button type="submit" name="ajouter">+ Inscrire</button>
            </form>
        </section>

        <!-- TABLEAU DES COLLABORATEURS -->
        <main>
            <?php if (empty($membres)): ?>
                <p class="no-results">Aucun collaborateur trouvé.</p>
            <?php else: ?>
                <p class="results-count"><?= count($membres) ?> collaborateur(s) trouvé(s)</p>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Âge</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membres as $m): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($m->getNom()) ?>
                                <?php if ($m->getRole() === "Directeur"): ?>
                                    <span class="badge-director">⭐ Directeur</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($m->getAge()) ?> ans</td>
                            <td><?= htmlspecialchars($m->getRole()) ?></td>
                            <td>
                                <a class="delete-btn"
                                   href="?delete=<?= $m->getId() ?>"
                                   onclick="return confirm('Supprimer <?= htmlspecialchars($m->getNom()) ?> ?')">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>

    </div>
</body>
</html>