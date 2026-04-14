<?php
require_once __DIR__ . '/Student.php';
require_once __DIR__ . '/Lesson.php';

class Admin {
    public function getDashboardData() {
        $studentModel = new Student();
        $lessonModel  = new Lesson();
        return [
            'students' => $studentModel->getAllStudents(),
            'lessons'  => $lessonModel->getAllLessons()
        ];
    }
}