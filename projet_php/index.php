<?php
require_once 'db.php';
require_once 'CollaborateurManager.php';

$manager = new CollaborateurManager($db);
$erreur = "";

// LOGIQUE : Ajout d'un membre (POST)
if (isset($_POST['ajouter'])) {
    if (!empty($_POST['nom']) && !empty($_POST['age']) && !empty($_POST['role'])) {
        if ($_POST['age'] >= 18) {
            $nouveau = new Collaborateur($_POST['nom'], $_POST['age'], $_POST['role']);
            $manager->add($nouveau);
        } else {
            $erreur = "Inscription refusée : l'employé doit être majeur.";
        }
    }
}

// LOGIQUE : Suppression
if (isset($_GET['delete'])) {
    $manager->delete($_GET['delete']);
    header('Location: index.php'); // Rafraîchit la page
}

// LOGIQUE : Recherche (GET) ou Affichage global
$membres = isset($_GET['q']) ? $manager->search($_GET['q']) : $manager->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nexus Hub</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <h1>Nexus Hub - Annuaire Interne</h1>

    <form method="GET">
        <input type="text" name="q" placeholder="Rechercher un nom ou un rôle...">
        <button type="submit">Filtrer</button>
    </form>

    <?php if($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>

    <section>
        <h2>Ajouter un collaborateur</h2>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="number" name="age" placeholder="Âge" required>
            <select name="role">
                <option value="Développeur">Développeur</option>
                <option value="Designer">Designer</option>
                <option value="Directeur">Directeur</option>
            </select>
            <button type="submit" name="ajouter">Inscrire</button>
        </form>
    </section>

    <table border="1">
        <tr><th>Nom</th><th>Âge</th><th>Rôle</th><th>Actions</th></tr>
        <?php foreach ($membres as $m): ?>
        <tr>
            <td>
                <?= htmlspecialchars($m->getNom()) ?>
                <?= $m->getRole() === "Directeur" ? " ⭐" : "" ?> </td>
            <td><?= htmlspecialchars($m->getAge()) ?> ans</td>
            <td><?= htmlspecialchars($m->getRole()) ?></td>
            <td><a href="?delete=<?= $m->getId() ?>" onclick="return confirm('Supprimer ?')">❌</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>