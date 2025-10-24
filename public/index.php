<?php
declare(strict_types=1);

// Front controller for the blog application
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Подключаем необходимые классы
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../auth/Auth.php';
require_once __DIR__ . '/../utils/Security.php';

// Получаем путь запроса
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$path = rtrim($path, '/');

// Если путь пустой, устанавливаем корневой путь
if (empty($path)) {
    $path = '/';
}

// Отладочная информация (удалить в продакшене)
error_log("Request URI: " . $_SERVER['REQUEST_URI']);
error_log("Parsed path: " . $path);

// Роутинг
switch ($path) {
    case '/':
    case '':
        require __DIR__ . '/../controllers/HomeController.php';
        break;
        
    case '/login':
        $_GET['action'] = 'login';
        require __DIR__ . '/../controllers/AuthController.php';
        break;
        
    case '/register':
        $_GET['action'] = 'register';
        require __DIR__ . '/../controllers/AuthController.php';
        break;
        
    case '/logout':
        $_GET['action'] = 'logout';
        require __DIR__ . '/../controllers/AuthController.php';
        break;
        
    case '/post':
        // Обработка действий с постами (create, edit, delete)
        require __DIR__ . '/../controllers/PostController.php';
        break;
        
    case '/profile':
        require __DIR__ . '/../controllers/ProfileController.php';
        break;
        
    case '/api/like':
        $_GET['action'] = 'like';
        require __DIR__ . '/../controllers/ApiController.php';
        break;
        
    case '/api/dislike':
        $_GET['action'] = 'dislike';
        require __DIR__ . '/../controllers/ApiController.php';
        break;
        
    case '/api/comment':
        $_GET['action'] = 'comment';
        require __DIR__ . '/../controllers/ApiController.php';
        break;
        
    case '/api/delete_comment':
        $_GET['action'] = 'delete_comment';
        require __DIR__ . '/../controllers/ApiController.php';
        break;
        
    case '/api/get_counters':
        $_GET['action'] = 'get_counters';
        require __DIR__ . '/../controllers/ApiController.php';
        break;
        
    default:
        // Проверяем, не является ли это страницей отдельного поста
        if (preg_match('/^\/post\/(\d+)$/', $path, $matches)) {
            $_GET['id'] = $matches[1];
            require __DIR__ . '/../controllers/PostController.php';
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
        break;
}


