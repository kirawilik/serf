<?php
require_once __DIR__ . '/../config/Database.php';

class Student {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllStudents() {
        $stmt = $this->pdo->prepare(
            "SELECT s.*, u.email
             FROM students s
             JOIN users u ON s.user_id = u.id_user
             ORDER BY s.name"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentByUserId($userId) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM students WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLevel($studentId, $level) {
        $stmt = $this->pdo->prepare(
            "UPDATE students SET level = ? WHERE id_student = ?"
        );
        return $stmt->execute([$level, $studentId]);
    }

    public function getStudentLessons($studentId) {
        $stmt = $this->pdo->prepare(
            "SELECT l.titre, l.coach, l.date_time, i.status_payment
             FROM inscriptions i
             JOIN lessons l ON i.lesson_id = l.id_lesson
             WHERE i.student_id = ?
             ORDER BY l.date_time ASC"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}