<?php
session_start();
require_once __DIR__ . '/../model/Student.php';

class StudentController {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    public function updateLevel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = intval($_POST['student_id']);
            $level     = htmlspecialchars($_POST['level']);

            $this->studentModel->updateLevel($studentId, $level);
            header('Location: ../Controller/AdminController.php?action=dashboard&updated=1');
            exit();
        }
    }
}

$controller = new StudentController();
if (isset($_GET['action']) && $_GET['action'] === 'updateLevel') {
    $controller->updateLevel();


}


