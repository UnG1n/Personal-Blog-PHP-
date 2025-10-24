<?php
declare(strict_types=1);

class Database {
    private static ?PDO $connection = null;
    
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'blog_db';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_CHARSET = 'utf8mb4';
    
    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                self::DB_HOST,
                self::DB_NAME,
                self::DB_CHARSET
            );
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            try {
                self::$connection = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
            } catch (PDOException $e) {
                throw new Exception('Ошибка подключения к базе данных: ' . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
    
    public static function closeConnection(): void {
        self::$connection = null;
    }
}
