<?php
// Les données ($lessons, $students, $inscriptions, $users)
// sont injectées par AdminController::dashboard() via include
// Ne pas accéder à cette vue directement sans passer par le contrôleur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <style>
        body { font-family: Arial; background: #eef2f7; }
        .container { width: 95%; margin: auto; }
        h1 { text-align: center; }
        h2 { background: #007BFF; color: white; padding: 10px; border-radius: 4px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; background: white; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #007BFF; color: white; }
        input, select { padding: 5px; margin: 5px; }
        button { padding: 5px 10px; cursor: pointer; }
        .btn { padding: 5px 10px; color: white; text-decoration: none; border-radius: 4px; display: inline-block; }
        .delete { background: #dc3545; }
        .edit { background: #28a745; }
        .logout { float: right; background: #6c757d; padding: 8px 12px; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tableau de bord Administrateur</h1>
    <a class="btn logout" href="../Controller/UserController.php?action=logout">Déconnexion</a>

    <?php if (isset($_GET['created'])): ?>
        <p class="success">Session créée avec succès.</p>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
        <p class="success">Modification effectuée avec succès.</p>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <p class="success"> Suppression effectuée avec succès.</p>
    <?php endif; ?>
    <?php if (isset($_GET['enrolled'])): ?>
        <p class="success"> Inscription effectuée avec succès.</p>
    <?php endif; ?>

    <h2>Sessions de Surf</h2>

    <form action="../Controller/LessonController.php?action=create" method="POST" style="margin-bottom:10px;">
        <input type="text" name="titre" placeholder="Titre" required>
        <input type="text" name="coach" placeholder="Coach" required>
        <input type="datetime-local" name="date_time" required>
        <button type="submit">Ajouter session</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Coach</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($lessons as $lesson): ?>
        <tr>
            <td><?= htmlspecialchars($lesson['id_lesson']); ?></td>
            <td><?= htmlspecialchars($lesson['titre']); ?></td>
            <td><?= htmlspecialchars($lesson['coach']); ?></td>
            <td><?= htmlspecialchars($lesson['date_time']); ?></td>
            <td>
                <a class="btn edit" href="../view/edit_lesson.php?id=<?= $lesson['id_lesson']; ?>">Modifier</a>
                <a class="btn delete"
                   href="../Controller/LessonController.php?action=delete&id=<?= $lesson['id_lesson']; ?>"
                   onclick="return confirm('Supprimer cette session ?');">
                   Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Étudiants</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Pays</th>
            <th>Niveau</th>
            <th>Email</th>
            <th>Modifier Niveau</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['id_student']); ?></td>
            <td><?= htmlspecialchars($student['name']); ?></td>
            <td><?= htmlspecialchars($student['country']); ?></td>
            <td><?= htmlspecialchars($student['level']); ?></td>
            <td><?= htmlspecialchars($student['email']); ?></td>
            <td>
                <form action="../Controller/StudentController.php?action=updateLevel" method="POST">
                    <input type="hidden" name="student_id" value="<?= $student['id_student']; ?>">
                    <select name="level">
                        <option value="Débutant" <?= $student['level']==='Débutant' ? 'selected' : ''; ?>>Débutant</option>
                        <option value="Intermédiaire" <?= $student['level']==='Intermédiaire' ? 'selected' : ''; ?>>Intermédiaire</option>
                        <option value="Avancé" <?= $student['level']==='Avancé' ? 'selected' : ''; ?>>Avancé</option>
                    </select>
                    <button type="submit">Modifier</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Inscriptions &amp; Paiements</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Étudiant</th>
            <th>Session</th>
            <th>Date</th>
            <th>Paiement</th>
            <th>Modifier</th>
        </tr>
        <?php foreach ($inscriptions as $ins): ?>
        <tr>
            <td><?= htmlspecialchars($ins['id_inscription']); ?></td>
            <td><?= htmlspecialchars($ins['name']); ?></td>
            <td><?= htmlspecialchars($ins['titre']); ?></td>
            <td><?= htmlspecialchars($ins['date_time']); ?></td>
            <td><?= htmlspecialchars($ins['status_payment']); ?></td>
            <td>
                <form action="../Controller/InscriptionController.php?action=updatePayment" method="POST">
                    <input type="hidden" name="id_inscription" value="<?= $ins['id_inscription']; ?>">
                    <select name="status_payment">
                        <option value="En attente" <?= $ins['status_payment']==='En attente' ? 'selected' : ''; ?>>En attente</option>
                        <option value="Payé" <?= $ins['status_payment']==='Payé' ? 'selected' : ''; ?>>Payé</option>
                    </select>
                    <button type="submit">Mettre à jour</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Utilisateurs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id_user']); ?></td>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= htmlspecialchars($user['email']); ?></td>
            <td><?= htmlspecialchars($user['role']); ?></td>
            <td>
                <?php if ($user['role'] !== 'admin'): ?>
                    <a class="btn delete"
                       href="../Controller/UserController.php?action=delete&id=<?= $user['id_user']; ?>"
                       onclick="return confirm('Supprimer cet utilisateur ?');">
                       Supprimer
                    </a>
                <?php else: ?>
                    <em>Administrateur</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>