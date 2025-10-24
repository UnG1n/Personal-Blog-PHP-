<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Comment {
    private PDO $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function create(int $postId, int $userId, string $text): bool {
        $stmt = $this->db->prepare('INSERT INTO comments (post_id, user_id, text) VALUES (?, ?, ?)');
        return $stmt->execute([$postId, $userId, $text]);
    }
    
    public function getByPostId(int $postId): array {
        $stmt = $this->db->prepare('
            SELECT c.*, u.login as author_login 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.post_id = ? 
            ORDER BY c.created_at ASC
        ');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }
    
    public function delete(int $commentId, int $userId): bool {
        $stmt = $this->db->prepare('DELETE FROM comments WHERE id = ? AND user_id = ?');
        return $stmt->execute([$commentId, $userId]);
    }
    
    public function getById(int $commentId): ?array {
        $stmt = $this->db->prepare('
            SELECT c.*, u.login as author_login 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.id = ?
        ');
        $stmt->execute([$commentId]);
        return $stmt->fetch() ?: null;
    }
}
