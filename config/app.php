<?php
declare(strict_types=1);

/**
 * Конфигурация приложения
 */
class AppConfig {
    // Основные настройки
    public const APP_NAME = 'Личный блог';
    public const APP_VERSION = '2.0.0';
    public const APP_DEBUG = true;
    
    // Настройки сессии
    public const SESSION_LIFETIME = 3600; // 1 час
    public const SESSION_NAME = 'BLOG_SESSION';
    
    // Настройки безопасности
    public const CSRF_TOKEN_LIFETIME = 3600;
    public const MAX_LOGIN_ATTEMPTS = 5;
    public const LOGIN_LOCKOUT_TIME = 900; // 15 минут
    
    // Настройки пагинации
    public const POSTS_PER_PAGE = 10;
    public const COMMENTS_PER_PAGE = 20;
    
    // Настройки валидации
    public const MIN_LOGIN_LENGTH = 3;
    public const MAX_LOGIN_LENGTH = 50;
    public const MIN_PASSWORD_LENGTH = 6;
    public const MAX_TITLE_LENGTH = 255;
    public const MAX_CONTENT_LENGTH = 10000;
    public const MAX_COMMENT_LENGTH = 1000;
    
    // Настройки кэширования
    public const CACHE_ENABLED = false;
    public const CACHE_LIFETIME = 300; // 5 минут
    
    /**
     * Инициализация приложения
     */
    public static function init(): void {
        // Настройки сессии
        if (session_status() === PHP_SESSION_NONE) {
            session_name(self::SESSION_NAME);
            session_set_cookie_params([
                'lifetime' => self::SESSION_LIFETIME,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
        
        // Настройки ошибок
        if (self::APP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        
        // Настройки времени
        date_default_timezone_set('Europe/Moscow');
        
        // Настройки кодировки
        mb_internal_encoding('UTF-8');
    }
    
    /**
     * Получает URL приложения
     */
    public static function getBaseUrl(): string {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $path = dirname($_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . $path;
    }
    
    /**
     * Получает путь к приложению
     */
    public static function getBasePath(): string {
        return dirname(__DIR__);
    }
}
