<?php
session_start();
require_once __DIR__ . '/../model/Lesson.php';

class LessonController {
    private $lessonModel;

    public function __construct() {
        $this->lessonModel = new Lesson();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre     = htmlspecialchars($_POST['titre']);
            $coach     = htmlspecialchars($_POST['coach']);
            $date_time = $_POST['date_time'];

            $this->lessonModel->createLesson($titre, $coach, $date_time);
            // FIX : rediriger vers le contrôleur, pas la vue directement
            header('Location: ../Controller/AdminController.php?action=dashboard&created=1');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id        = intval($_POST['id_lesson']);
            $titre     = htmlspecialchars($_POST['titre']);
            $coach     = htmlspecialchars($_POST['coach']);
            $date_time = $_POST['date_time'];

            $this->lessonModel->updateLesson($id, $titre, $coach, $date_time);
            // FIX : rediriger vers le contrôleur, pas la vue directement
            header('Location: ../Controller/AdminController.php?action=dashboard&updated=1');
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->lessonModel->deleteLesson($id);
            // FIX : rediriger vers le contrôleur, pas la vue directement
            header('Location: ../Controller/AdminController.php?action=dashboard&deleted=1');
            exit();
        }
    }
}

$controller = new LessonController();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $controller->create();
            break;
        case 'update':
            $controller->update();
            break;
        case 'delete':
            $controller->delete();
            break;
    }
}