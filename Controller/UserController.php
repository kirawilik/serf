<?php
session_start();
require_once __DIR__ . '/../model/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $country  = htmlspecialchars(trim($_POST['country']));
            $level    = htmlspecialchars(trim($_POST['level']));

            if (!empty($username) && !empty($email) && !empty($password)
                && !empty($country) && !empty($level)) {
                $result = $this->userModel->register($username, $email, $password, $country, $level);
                if ($result) {
                    header('Location: ../view/login.php?success=1');
                } else {
                    header('Location: ../view/login.php?error=register');
                }
            } else {
                header('Location: ../view/login.php?error=empty');
            }
            exit();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!empty($email) && !empty($password)) {
                $user = $this->userModel->login($email, $password);
                
                if ($user) {
                    $_SESSION['user'] = $user;
                    if ($user['role'] === 'admin') {
                        header('Location: ../Controller/AdminController.php?action=dashboard');
                    } else {
                        header('Location: ../view/account_student.php');
                    }
                } else {
                    header('Location: ../view/login.php?error=login');
                }
            } else {
                header('Location: ../view/login.php?error=empty');
            }
            exit();
        }
    }

    
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ../view/login.php');
        exit();
    }

    public function deleteUser() {
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            if (isset($_GET['id'])) {
                $userId = intval($_GET['id']);
                $this->userModel->deleteUser($userId);
                header('Location: ../Controller/AdminController.php?action=dashboard&deleted=1');
                exit();
            }
        } else {
            header('Location: ../view/login.php');
            exit();
        }
    }
}

$controller = new UserController();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            $controller->register();
            break;
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'delete':
            $controller->deleteUser();
            break;
        default:
            header('Location: ../view/login.php');
            exit();
    }
}