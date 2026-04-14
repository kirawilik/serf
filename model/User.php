<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function register($username, $email, $password, $country, $level) {
        try {
            $this->pdo->beginTransaction();

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare(
                "INSERT INTO users (username, email, password, role, created_at)
                 VALUES (?, ?, ?, 'user', NOW())"
            );
            $stmt->execute([$username, $email, $hashedPassword]);
            $userId = $this->pdo->lastInsertId();

            $stmt2 = $this->pdo->prepare(
                "INSERT INTO students (user_id, name, country, level)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt2->execute([$userId, $username, $country, $level]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare(
            "SELECT id_user, username, email, role, created_at
             FROM users ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId) {
        try {
            $this->pdo->beginTransaction();

            $stmtCheck = $this->pdo->prepare(
                "SELECT role FROM users WHERE id_user = ?"
            );
            $stmtCheck->execute([$userId]);
            $user = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if (!$user || $user['role'] === 'admin') {
                $this->pdo->rollBack();
                return false;
            }

            $stmt = $this->pdo->prepare(
                "SELECT id_student FROM students WHERE user_id = ?"
            );
            $stmt->execute([$userId]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($student) {
                $stmt1 = $this->pdo->prepare(
                    "DELETE FROM inscriptions WHERE student_id = ?"
                );
                $stmt1->execute([$student['id_student']]);

                $stmt2 = $this->pdo->prepare(
                    "DELETE FROM students WHERE id_student = ?"
                );
                $stmt2->execute([$student['id_student']]);
            }

            $stmt3 = $this->pdo->prepare(
                "DELETE FROM users WHERE id_user = ?"
            );
            $stmt3->execute([$userId]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}