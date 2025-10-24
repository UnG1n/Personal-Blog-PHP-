<?php
declare(strict_types=1);

class Security {
    public static function escapeHtml(string $string): string {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    public static function validateLogin(string $login): bool {
        return (bool) preg_match('/^[a-zA-Zа-яА-Я0-9_]{3,50}$/u', $login);
    }
    
    public static function validatePassword(string $password): bool {
        return strlen($password) >= 6;
    }
    
    public static function validateTitle(string $title): bool {
        return strlen(trim($title)) >= 1 && strlen($title) <= 255;
    }
    
    public static function validateContent(string $content): bool {
        return strlen(trim($content)) >= 1;
    }
    
    public static function validateComment(string $text): bool {
        return strlen(trim($text)) >= 1 && strlen($text) <= 1000;
    }
    
    public static function sanitizeInput(string $input): string {
        return trim(strip_tags($input));
    }
    
    public static function generateCsrfToken(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function validateCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Проверяет CSRF токен для POST запросов
     */
    public static function validateCsrfRequest(): bool {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return true;
        }
        
        $token = $_POST['csrf_token'] ?? '';
        return self::validateCsrfToken($token);
    }
    
    /**
     * Генерирует скрытое поле с CSRF токеном
     */
    public static function csrfField(): string {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}
