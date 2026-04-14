<?php
require_once __DIR__ . '/../config/Database.php';

class Inscription {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function enrollStudent($studentId, $lessonId, $status = 'En attente') {
        $stmt = $this->pdo->prepare(
            "INSERT INTO inscriptions (student_id, lesson_id, status_payment)
             VALUES (?, ?, ?)"
        );
        return $stmt->execute([$studentId, $lessonId, $status]);
    }

    public function updatePaymentStatus($inscriptionId, $status) {
        $stmt = $this->pdo->prepare(
            "UPDATE inscriptions SET status_payment = ?
             WHERE id_inscription = ?"
        );
        return $stmt->execute([$status, $inscriptionId]);
    }

    public function getAllInscriptions() {
        $stmt = $this->pdo->prepare(
            "SELECT i.id_inscription, s.name, l.titre, l.date_time, i.status_payment
             FROM inscriptions i
             JOIN students s ON i.student_id = s.id_student
             JOIN lessons l ON i.lesson_id = l.id_lesson
             ORDER BY l.date_time"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isStudentEnrolled($studentId, $lessonId) {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM inscriptions
             WHERE student_id = ? AND lesson_id = ?"
        );
        $stmt->execute([$studentId, $lessonId]);
        return $stmt->fetchColumn() > 0;
    }
}