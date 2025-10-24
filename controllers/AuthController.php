<?php
declare(strict_types=1);

$userModel = new User();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        Auth::redirectIfLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = Security::sanitizeInput($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (!Security::validateLogin($login) || !Security::validatePassword($password)) {
                $error = 'Неверные данные для входа';
            } else {
                $user = $userModel->login($login, $password);
                if ($user) {
                    Auth::login($user['id'], $user['login']);
                    header('Location: /');
                    exit;
                } else {
                    $error = 'Неверный логин или пароль';
                }
            }
        }
        require __DIR__ . '/../views/auth/login.php';
        break;
        
    case 'register':
        Auth::redirectIfLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = Security::sanitizeInput($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (!Security::validateLogin($login)) {
                $error = 'Логин должен содержать только буквы (включая русские), цифры и подчеркивания (3-50 символов)';
            } elseif (!Security::validatePassword($password)) {
                $error = 'Пароль должен содержать минимум 6 символов';
            } elseif ($password !== $confirmPassword) {
                $error = 'Пароли не совпадают';
            } else {
                if ($userModel->register($login, $password)) {
                    $success = 'Регистрация успешна! Теперь вы можете войти в систему.';
                } else {
                    $error = 'Пользователь с таким логином уже существует';
                }
            }
        }
        require __DIR__ . '/../views/auth/register.php';
        break;
        
    case 'logout':
        Auth::logout();
        header('Location: /');
        exit;
        
    default:
        header('Location: /');
        exit;
}
