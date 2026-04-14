<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function createLesson($titre, $coach, $date_time) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO lessons (titre, coach, date_time) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$titre, $coach, $date_time]);
    }

    public function getAllLessons() {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM lessons ORDER BY date_time ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLessonById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM lessons WHERE id_lesson = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLesson($id, $titre, $coach, $date_time) {
        $stmt = $this->pdo->prepare(
            "UPDATE lessons SET titre = ?, coach = ?, date_time = ?
             WHERE id_lesson = ?"
        );
        return $stmt->execute([$titre, $coach, $date_time, $id]);
    }

    public function deleteLesson($id) {
        try {
            $this->pdo->beginTransaction();

            $stmt1 = $this->pdo->prepare(
                "DELETE FROM inscriptions WHERE lesson_id = ?"
            );
            $stmt1->execute([$id]);

            $stmt2 = $this->pdo->prepare(
                "DELETE FROM lessons WHERE id_lesson = ?"
            );
            $stmt2->execute([$id]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}