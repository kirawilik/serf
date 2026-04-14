<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../model/Lesson.php';

$lessonModel = new Lesson();

if (!isset($_GET['id'])) {
    header('Location: ../Controller/AdminController.php?action=dashboard');
    exit();
}

$lesson = $lessonModel->getLessonById(intval($_GET['id']));

if (!$lesson) {
    header('Location: ../Controller/AdminController.php?action=dashboard');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une session</title>
    <style>
        body { font-family: Arial; background: #eef2f7; }
        .container { width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        input, button { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: block; text-align: center; margin-top: 10px; color: #007BFF; }
    </style>
</head>
<body>
<div class="container">
    <h2>Modifier la session</h2>
    <form action="../Controller/LessonController.php?action=update" method="POST">
        <input type="hidden" name="id_lesson" value="<?= htmlspecialchars($lesson['id_lesson']); ?>">
        <input type="text" name="titre"
               value="<?= htmlspecialchars($lesson['titre']); ?>" placeholder="Titre" required>
        <input type="text" name="coach"
               value="<?= htmlspecialchars($lesson['coach']); ?>" placeholder="Coach" required>
        <input type="datetime-local" name="date_time"
               value="<?= date('Y-m-d\TH:i', strtotime($lesson['date_time'])); ?>" required>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="../Controller/AdminController.php?action=dashboard">← Retour au dashboard</a>
</div>
</body>
</html>