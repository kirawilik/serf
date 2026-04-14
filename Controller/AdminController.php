<?php
session_start();
require_once __DIR__ . '/../model/Student.php';
require_once __DIR__ . '/../model/Lesson.php';
require_once __DIR__ . '/../model/Inscription.php';
require_once __DIR__ . '/../model/User.php';

class AdminController {
    private $studentModel;
    private $lessonModel;
    private $inscriptionModel;
    private $userModel;

    public function __construct() {
        $this->studentModel     = new Student();
        $this->lessonModel      = new Lesson();
        $this->inscriptionModel = new Inscription();
        $this->userModel        = new User();
    }

    public function dashboard() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ../view/login.php');
            exit();
        }

        $students     = $this->studentModel->getAllStudents();
        $lessons      = $this->lessonModel->getAllLessons();
        $inscriptions = $this->inscriptionModel->getAllInscriptions();
        $users        = $this->userModel->getAllUsers();

        include __DIR__ . '/../view/account_admin.php';
    }
}

$controller = new AdminController();
if (isset($_GET['action']) && $_GET['action'] === 'dashboard') {
    $controller->dashboard();
} else {
    $controller->dashboard();
}