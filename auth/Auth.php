<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/User.php';

class Auth {
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
    
    public static function getCurrentUser(): ?array {
        if (!self::isLoggedIn()) {
            return null;
        }
        
        $userModel = new User();
        return $userModel->getUserById($_SESSION['user_id']);
    }
    
    public static function getCurrentUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
    
    public static function login(int $userId, string $login): void {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_login'] = $login;
    }
    
    public static function logout(): void {
        session_destroy();
        session_start();
    }
    
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }
    
    public static function redirectIfLoggedIn(): void {
        if (self::isLoggedIn()) {
            header('Location: /');
            exit;
        }
    }
}
