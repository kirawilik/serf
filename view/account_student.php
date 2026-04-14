
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../model/Student.php';

$studentModel = new Student();
$student      = $studentModel->getStudentByUserId($_SESSION['user']['id_user']);
$lessons      = $studentModel->getStudentLessons($student['id_student']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
    <style>
        body { font-family: Arial; background: #eef2f7; }
        .container { width: 80%; margin: auto; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #28a745; color: white; }
        .logout { float: right; background: #6c757d; padding: 8px 12px; color: white; text-decoration: none; border-radius: 4px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 13px; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
<div class="container">
    <h1>Bienvenue <?= htmlspecialchars($student['name']); ?> </h1>
    <a class="logout" href="../Controller/UserController.php?action=logout">Déconnexion</a>

    <h2>Mes informations</h2>
    <p><strong>Pays :</strong> <?= htmlspecialchars($student['country']); ?></p>
    <p><strong>Niveau :</strong> <?= htmlspecialchars($student['level']); ?></p>

    <h2>Mes sessions de surf</h2>
    <?php if (empty($lessons)): ?>
        <p>Vous n'êtes inscrit à aucune session pour le moment.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Titre</th>
            <th>Coach</th>
            <th>Date</th>
            <th>Statut de paiement</th>
        </tr>
        <?php foreach ($lessons as $lesson): ?>
        <tr>
            <td><?= htmlspecialchars($lesson['titre']); ?></td>
            <td><?= htmlspecialchars($lesson['coach']); ?></td>
            <td><?= htmlspecialchars($lesson['date_time']); ?></td>
            <td>
                <?php if ($lesson['status_payment'] === 'Payé'): ?>
                    <span class="badge badge-success">Payé</span>
                <?php else: ?>
                    <span class="badge badge-warning">En attente</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>
</body>
</html>