<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel {
    
    public function register(string $login, string $password): bool {
        // Проверяем, не существует ли уже пользователь с таким логином
        if ($this->fetchOne('SELECT id FROM users WHERE login = ?', [$login])) {
            return false; // Пользователь уже существует
        }
        
        // Хешируем пароль
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Создаем нового пользователя
        return $this->execute('INSERT INTO users (login, password_hash) VALUES (?, ?)', [$login, $passwordHash]);
    }
    
    public function login(string $login, string $password): ?array {
        $user = $this->fetchOne('SELECT id, login, password_hash FROM users WHERE login = ?', [$login]);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            return [
                'id' => $user['id'],
                'login' => $user['login']
            ];
        }
        
        return null;
    }
    
    public function getUserById(int $id): ?array {
        return $this->fetchOne('SELECT id, login, created_at FROM users WHERE id = ?', [$id]);
    }
    
    public function getUserStats(int $userId): array {
        $sql = '
            SELECT 
                COUNT(*) as post_count,
                COALESCE(SUM(views), 0) as total_views,
                COALESCE(SUM(likes), 0) as total_likes,
                COALESCE(SUM(dislikes), 0) as total_dislikes
            FROM posts 
            WHERE user_id = ?
        ';
        
        $result = $this->fetchOne($sql, [$userId]);
        
        return [
            'post_count' => (int)($result['post_count'] ?? 0),
            'total_views' => (int)($result['total_views'] ?? 0),
            'total_likes' => (int)($result['total_likes'] ?? 0),
            'total_dislikes' => (int)($result['total_dislikes'] ?? 0)
        ];
    }
}
