<?php
session_start();
require_once __DIR__ . '/../model/Inscription.php';

class InscriptionController {
    private $inscriptionModel;

    public function __construct() {
        $this->inscriptionModel = new Inscription();
    }

    public function enroll() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = intval($_POST['student_id']);
            $lessonId  = intval($_POST['lesson_id']);
            $status    = $_POST['status_payment'] ?? 'En attente';

            if (!$this->inscriptionModel->isStudentEnrolled($studentId, $lessonId)) {
                $this->inscriptionModel->enrollStudent($studentId, $lessonId, $status);
            }
            header('Location: ../Controller/AdminController.php?action=dashboard&enrolled=1');
            exit();
        }
    }

    public function updatePayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inscriptionId = intval($_POST['id_inscription']);
            $status        = htmlspecialchars($_POST['status_payment']);

            $this->inscriptionModel->updatePaymentStatus($inscriptionId, $status);
            header('Location: ../Controller/AdminController.php?action=dashboard&updated=1');
            exit();
        }
    }
}

// ➤ Appel direct
$controller = new InscriptionController();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'enroll':
            $controller->enroll();
            break;
        case 'updatePayment':
            $controller->updatePayment();
            break;
    }
}